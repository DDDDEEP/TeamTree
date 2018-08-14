<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use App\Http\Resources\CommonCollection;

class PermissionRoleController extends Controller
{
    public function index()
    {
        return new CommonCollection(PermissionRole::all());
    }
}
