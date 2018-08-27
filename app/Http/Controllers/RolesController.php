<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Libraries\CollectionFilter;
use App\Http\Resources\CommonCollection;

class RolesController extends Controller
{
    public function index(RoleRequest $request)
    {
        return new CommonCollection(
            (new CollectionFilter(Role::all()))->filterByRequest($request)
        );
    }
}
