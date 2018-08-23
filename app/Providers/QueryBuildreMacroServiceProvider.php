<?php
namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use App\Models\Relationships;

class QueryBuildreMacroServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // /**
        //  * 加载存在的关联
        //  *
        //  * @param  array|string  $relations
        //  * @return \Illuminate\Database\Eloquent\Builder|static
        //  */
        // Builder::macro('withExist', function ($relations) {
        //     $relationships = (new Relationships($this->newModelInstance()))
        //         ->all()
        //         ->keys()
        //         ->all();
        //     if (is_string($relations)) {
        //         $relations = explode(',', $relations);
        //     }
        //     $relations = array_intersect($relations, $relationships);

        //     return $this->with($relations);
        // });
    }

}