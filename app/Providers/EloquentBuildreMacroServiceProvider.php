<?php
namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Relationships;

class EloquentBuildreMacroServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /**
         * 加载存在的关联
         *
         * @param  string|array  $relations
         * @return $this
         */
        Builder::macro('withExistRelations', function ($relations) {
            $exist_relations = $relations;
            dd((new Relationships($this->newModelInstance()))->all());
            if (is_array($exist_relations)) {
                1;
            } else {
                1;
            }
            return $this->with;
        });
    }

}