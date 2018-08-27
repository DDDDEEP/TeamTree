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
         * @return \Illuminate\Pagination\LengthAwarePaginator
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
    }

}