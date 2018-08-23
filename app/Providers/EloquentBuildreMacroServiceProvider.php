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
         * @param  array|string  $relations
         * @return \Illuminate\Database\Eloquent\Builder|static
         */
        Builder::macro('withExist', function ($relations) {
            dd($this);
            $relationships = (new Relationships($this->newModelInstance()))
                ->all()
                ->keys()
                ->all();
            if (is_string($relations)) {
                $relations = explode(',', $relations);
            }
            $relations = array_intersect($relations, $relationships);

            return $this->with($relations);
        });

        /**
         * 根据请求参数过滤集合数据
         *
         * @param  array  $data
         * @return \Illuminate\Database\Eloquent\Collection|
         */
        Builder::macro('filter', function ($data) {
            dd($this->with('project'));
            $result = Arr::exists($data, 'relation') ? $this->withExist($data['relation']) : $this->all();
            dd($result);
        });
    }

}