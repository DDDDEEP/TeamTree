<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Resources\CommonCollection;

class PermissionsController extends Controller
{
    public function index()
    {
        return new CommonCollection(Permission::all());
    }
}
