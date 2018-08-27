<?php

namespace App\Libraries;

use App\Libraries\Relationships;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CollectionFilter
{
    /**
     * 数据集合
     *
     * @var \Illuminate\Support\Collection
     */
    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * 通过请求对象过滤
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function filterByRequest($request)
    {
        $data = $this->collection;
        if ($data->count() == 0) {
            return $data;
        }

        $columns = [];    // 模型字段
        $relationships = [];    // 关联属性
        $suffixs = ['@eq', '@neq', '@like'];    // 字段后缀值

        // 初始化数组
        $model = $data->first()->newInstance();
        $columns = $model->getTableColumns();
        $relationships = (new Relationships($model))->all();

        // 加载关联数据
        $relationships_keys = $relationships->keys()->all();
        $relate_keys = explode(',', $request->input('relate', ''));
        $relations = array_intersect($relate_keys, $relationships_keys);

        foreach ($data as $key => &$value) {
            $value->load($relations);
        }

        // 遍历处理
        foreach ($request->all() as $key => $value) {
            $key = str_replace('-', '.', $key);
            $values = explode(',', $value);
            switch ($key) {
                case 'relate':
                case 'page':
                case 'perPage':
                    break;
                case 'sortBy':
                    $sort_list = [];
                    $orders = ['asc', 'desc'];

                    foreach ($values as $item) {
                        $item = array_pad(explode('.', $item), 2, 'asc');
                        if (count($item) == 2 && in_array($item[1], $orders)
                            && in_array($item[0], $columns)) {
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
                        if (in_array($item, $columns)) {
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
                    if (Str::startsWith($key, '*')) {
                        break;
                    }

                    $key .= !Str::contains($key, '@') ? '@eq' : '';

                    foreach ($suffixs as $suffix) {
                        if (!Str::endsWith($key, $suffix)) {
                            continue;
                        }

                        $field = Str::replaceLast($suffix, '', $key);
                        switch ($suffix) {
                            case '@eq':
                                $data = $data->whereIn($field, $values);
                                break;
                            case '@neq':
                                $data = $data->whereNotIn($field, $values);
                                break;
                            case '@like':
                                $data = $data->filter(function ($item) use ($field, $values) {
                                    foreach ($values as $value) {
                                        if (Str::contains(Arr::get($item->toArray(), $field, ''), $value)) {
                                            return true;
                                        }
                                    }
                                    return false;
                                });
                                break;
                            default:
                                # code...
                                break;
                        }
                        break;
                    }
                    break;
            }
        }

        if ($request->has('page') || $request->has('perPage')) {
            $data = $data->paginate(
                $request->input('page', 1),
                $request->input('perPage', 15)
            );
        }

        return $data;
    }
}