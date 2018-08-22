<?php
namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacroServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /**
         * 根据请求参数过滤集合数据
         *
         * @param  array  $data/*
         * @param  array  $columns
         * @param  array  $relationships
         * @return \Illuminate\Support\Collection
         */
        Collection::macro('filterByParams', function ($data, $columns, $relationships) {
            $suffixs = ['eq', 'neq'];
            $special_keys = ['unique', 'sortBy', 'order'];

            // 先加载关联数据
            if (Arr::exists($data, 'relate')) {
                // 得到有效的
                $data_relates = explode(',', $data['relate']);
                $relationships_relates = Arr::collapse(array_values($relationships));
                $data_relates = array_intersect($data_relates, $relationships_relates);
                $this->map(function ($item) use ($data_relates) {
                    foreach ($relates as $relate) {
                        $a;
                    }
                });
            }
            foreach ($data as $key => $value) {
                if (Arr::exists($special_keys, $key)) {
                    switch ($key) {
                        case 'relate':
                            break;
                        case 'unique':
                            break;
                        case 'sortBy':
                            break;
                        default:
                            break;
                    }
                } else {
                    dd(1);
                }
            }
        });


    }

}