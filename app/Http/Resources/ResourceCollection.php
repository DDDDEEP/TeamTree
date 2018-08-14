<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    /**
     * 模型属性字段名，用于过滤集合中的属性值
     * 键为属性名，值为参数中出现的对应情况，包括：
     * eq：等于，neq：不等于
     *
     * @var array
     */
    public $field_params = [];

    /**
     * 单关联的模型属性字段名
     * 键为关联名，值为数组，其结构、含义与$field_params一致
     *
     * @var array
     */
    public $relate_field_params = [];

    /**
     * 对于同名字段属性，参数可带有的后缀（注：没有后缀即为eq）
     * eq：等于，neq：不等于
     *
     * @var array
     */
    public $suffixs = ['eq', 'neq',];

    /**
     * 特殊参数对
     * 用于根据特殊条件过滤集合，包括键值：
     * relate：关联对象，unique：去重，sortBy：排序，order：排序顺序
     *
     * @var array
     */
    public $special_params = [
        'relate' => [],
        'unique' => [],
        'sortBy' => [],
        'order' => [],
    ];

    /**
     * 根据集合中模型对象初始化属性字段名数组
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        if ($this->collection->count() != 0) {
            $fields = $this->collection->first()->getAttributes();
            foreach ($fields as $field => $value) {
                $this->field_params[$field] = [];
            }
        }
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * 统一处理方法
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handleByMethods($request)
    {
        $this->initParams($request);

        $data = $this->collection;
        $data = $this->handleByRelate($data);
        $data = $this->filterByField($data);
        $data = $this->filterByUnique($data);
        $data = $this->handleBySort($data);

        return $data;
    }

    /**
     * 根据请求对象初始化类成员数组
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function initParams($request)
    {
        $data = $request->all();

        /* 优先处理relate，以加载关联字段 */
        if (array_key_exists('relate', $data)) {
            $relates = explode(',', $data['relate']);
            $this->initRelateParams($relates);
        }

        /* 对参数键值对分类 */
        foreach ($data as $key => $value) {
            $values = explode(',', $value);
            if (array_key_exists($key, $this->special_params) && $key != 'relate') {
                // 添加特殊参数键值对
                $this->special_params[$key] = $values;
            } else {
                // 处理字段参数键值对
                $this->initFieldParams($key, $values);
            }
        }

        /* 对特殊参数键值对进行处理 */
        $this->initSpecialParams();
    }

    /**
     * 添加对应值至特殊字段类成员数组
     *
     * @param  array  $relates  关系名数组
     */
    protected function initRelateParams($relates)
    {
        $first_model = $this->collection->first();

        // 提取有效关联名
        foreach ($relates as $relate) {
            if (method_exists($first_model, $relate)) {
                array_push($this->special_params['relate'], $relate);
            }
        }

        // 获得单关联属性字段名并初始化成员数组
        foreach ($this->special_params['relate'] as $relate) {
            // 调用关联函数，根据返回值是否为模型实例判断其为单关联模型
            if ($first_model->$relate instanceof Model && $first_model->$relate->count() != 0) {
                $fields = $first_model->$relate->getAttributes();
                $new_relate_array = [];
                foreach ($fields as $field => $value) {
                    $new_relate_array[$field] = [];
                }
                $this->relate_field_params[$relate] = $new_relate_array;
            }
        }
    }

    /**
     * 处理过滤特殊字段类成员数组
     */
    protected function initSpecialParams()
    {
        if (count($this->special_params['unique']) != 0) {
            foreach ($this->special_params['unique'] as &$field) {
                if (!array_key_exists($field, $this->field_params)) {
                    unset($field);
                }
            }
        }
        if (count($this->special_params['sortBy']) != 0) {
            foreach ($this->special_params['sortBy'] as $field) {
                if (!array_key_exists($field, $this->field_params)) {
                    unset($field);
                }
            }

            // 补全缺少的order为asc
            $diff = count($this->special_params['sortBy']) - count($this->special_params['order']);
            while ($diff-- > 0) {
                array_push($this->special_params['order'], 'asc');
            }
        }
    }

    /**
     * 添加新键值对至字段类成员数组
     *
     * @param  string  $key  键名
     * @param  array  $values  值数组
     */
    protected function initFieldParams($key, $values)
    {
        if (!strpos($key, '-')) {
            // 处理属性同名参数键值对
            $key_without_suffix = substr($key, 0, strrpos($key, '_')); // 对于有后缀的参数，不带后缀的参数键名
            $suffix_in_key = substr($key, strrpos($key, '_') + 1); // 对于有后缀的参数，该参数键对应后缀名

            if (array_key_exists($key, $this->field_params)) {
                // 若直接含有对应属性名
                $this->field_params[$key]['eq'] = $values;
            } else if (array_key_exists($key_without_suffix, $this->field_params)
                && in_array($suffix_in_key, $this->suffixs)) {
                // 若参数不带后缀时有对应属性名，且有指定后缀
                $this->field_params[$key_without_suffix][$suffix_in_key] = $values;
            }
        } else {
            // 处理外键关联的情况（如exam-id_neq=1,2）
            $relate_in_key = substr($key, 0, strpos($key, '-'));

            // 若键值对中的关联名没有出现在单关联数组中，跳过
            if (!array_key_exists($relate_in_key, $this->relate_field_params)) {
                return;
            }

            $key_without_relate = substr($key, strpos($key, '-') + 1); // 不带关联名的键名
            $key_without_suffix = substr(
                $key_without_relate,
                0,
                strrpos($key, '_')
            ); // 对于有后缀的参数，不带后缀的参数键名
            $suffix_in_key = substr(
                $key_without_relate,
                strrpos($key_without_relate, '_') + 1
            ); // 对于有后缀的参数，该参数键对应后缀名

            $the_field_params = &$this->relate_field_params[$relate_in_key];
            if (array_key_exists($key_without_relate, $the_field_params)) {
                // 若直接含有对应属性名
                $the_field_params[$key_without_relate]['eq'] = $values;
            } else if (array_key_exists($key_without_suffix, $the_field_params)
                && in_array($suffix_in_key, $this->suffixs)) {
                // 若参数不带后缀时有对应属性名，且有指定后缀
                $the_field_params[$key_without_relate][$key_without_suffix] = $values;
            }
        }
    }

    /**
     * 通过关系扩增数据
     */
    protected function handleByRelate($data)
    {
        if (count($this->special_params['relate']) == 0) {
            return $data;
        }

        foreach ($data as &$collection_item) {
            foreach ($this->special_params['relate'] as $relate) {
                $collection_item->load($relate);
            }
        }

        return $data;
    }

    /**
     * 根据分类后的参数数组过滤集合
     */
    protected function filterByField($data)
    {
        /* 处理直接字段参数 */
        foreach ($this->field_params as $field => $operators) {
            foreach ($operators as $operator => $values) {
                switch ($operator) {
                    case 'eq':
                        $data = $data->whereIn($field, $values);
                        break;
                    case 'neq':
                        $data = $data->whereNotIn($field, $values);
                        break;
                    default:
                        break;
                }
            }
        }

        /* 处理关联字段参数 */
        foreach ($this->relate_field_params as $relate => $fields) {
            foreach ($fields as $field => $operators) {
                foreach ($operators as $operator => $values) {
                    switch ($operator) {
                        case 'eq':
                            $data = $data->whereIn("{$relate}.{$field}", $values);
                            break;
                        case 'neq':
                            $data = $data->whereNotIn("{$relate}.{$field}", $values);
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 通过给出的字段去重
     */
    public function filterByUnique($data)
    {
        if (count($this->special_params['unique']) == 0) {
            return $data;
        }

        foreach ($this->special_params['unique'] as $field) {
            if (array_key_exists($field, $this->field_params)) {
                $data = $data->unique($field);
            }
        }

        return $data;
    }

    /**
     * 通过排序处理数据
     */
    public function handleBySort($data)
    {
        if (count($this->special_params['sortBy']) == 0) {
            return $data;
        }

        $useful_sort = [];
        for ($i = 0; $i < count($this->special_params['sortBy']); ++$i) {
            $field = $this->special_params['sortBy'][$i];
            $useful_sort[$field] = ($this->special_params['order'][$i] == 'desc' ? false : true);
        }

        $data = $data->sort(function ($a, $b) use ($useful_sort) {
            foreach ($useful_sort as $key => $value) {
                $lt = $a[$key];
                $rt = $b[$key];
                if ($lt == $rt) {
                    continue;
                } else {
                    return $value ? $lt > $rt : $lt < $rt;
                }
            }
        });

        return $data;
    }
}
