<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use App\Libraries\CollectionFilter;
use App\Http\Resources\CommonCollection;
use App\Http\Requests\PermissionRoleRequest;

class PermissionRoleController extends Controller
{
    public function index(PermissionRoleRequest $request)
    {
        return new CommonCollection(
            (new CollectionFilter(PermissionRole::all()))->filterByRequest($request)
        );
    }
}
