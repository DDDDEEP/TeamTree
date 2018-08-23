<?php
namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionMacroServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param  int  $page
         * @param  int  $perPage
         * @param  int  $total
         * @param  string  $pageName
         * @return array
         */
        Collection::macro('paginate', function ($page = null, $perPage = 15, $total = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

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