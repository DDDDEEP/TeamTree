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
    }

}