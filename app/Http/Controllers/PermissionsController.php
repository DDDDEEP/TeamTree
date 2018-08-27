<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Libraries\CollectionFilter;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\PermissionCollection;

class PermissionsController extends Controller
{
    public function index(PermissionRequest $request)
    {
        return new CommonCollection(
            (new CollectionFilter(Permission::all()))->filterByRequest($request)
        );
    }
}
