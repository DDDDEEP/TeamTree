<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;
use App\Models\Relationships;

class ResourceCollection extends BaseResourceCollection
{
    /**
     * 模型字段
     *
     * @var array
     */
    public $columns = [];

    /**
     * 关联属性
     *
     * @var array
     */
    public $relationships = [];

    /**
     * 字段后缀值
     *
     * @var array
     */
    public $suffixs = ['@eq', '@neq',];

    /**
     * 根据集合中模型对象初始化属性字段名数组
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        if ($this->collection->count() != 0) {
            $model = $this->collection->first()->newInstance();
            $this->columns = $model->getTableColumns();
            $this->relationships = (new Relationships($model))->all();
        }
    }

    /**
     * 统一处理方法
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function handleByRequest($request)
    {
        $data = $this->collection;

        // 加载关联数据
        $relationships_keys = $this->relationships->keys()->all();
        $relate_keys = explode(',', $request->input('relate', ''));
        $relations = array_intersect($relate_keys, $relationships_keys);

        foreach ($data as $key => &$value) {
            $value->load($relations);
        }

        foreach ($request->all() as $key => $value) {
            $key = str_replace('-', '.', $key);
            $values = explode(',', $value);
            switch ($key) {
                case 'sortBy':
                    $sort_list = [];
                    $orders = ['asc', 'desc'];

                    foreach ($values as $item) {
                        $item = array_pad(explode('.', $item), 2, 'asc');
                        if (count($item) == 2 && in_array($item[1], $orders)
                            && in_array($item[0], $this->columns)) {
                            $sort_list[$item[0]] = $item[1];
                        }
                    }

                    $data = $data->sort(function ($a, $b) use ($sort_list) {
                        foreach ($sort_list as $key => $value) {
                            $lt = $a->$key;
                            $rt = $b->$key;
                            if ($lt == $rt) {
                                continue;
                            } else {
                                return $value == 'asc' ? $lt > $rt : $lt < $rt;
                            }
                        }
                    });
                    break;
                case 'unique':
                    $unique_list = [];

                    foreach ($values as $item) {
                        if (in_array($item, $this->columns)) {
                            array_push($unique_list, $item);
                        }
                    }

                    $data = $data->unique(function ($item) use ($unique_list) {
                        $result = '';
                        foreach ($unique_list as $column) {
                            $result .= $item->$column . '-';
                        }
                        return $result;
                    });
                    break;
                default:
                    if (!Str::contains($key, '@')) {
                        $key .= '@eq';
                    }

                    foreach ($this->suffixs as $suffix) {
                        if (Str::endsWith($key, $suffix)) {
                            $field = Str::replaceLast($suffix, '', $key);
                            switch ($suffix) {
                                case 'eq':
                                    $data = $data->whereIn($field, $values);
                                    break;
                                case 'neq':
                                    $data = $data->whereNotIn($field, $values);
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                        }
                    }
                    break;
            }
        }

        return $data;
    }
}