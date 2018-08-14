<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Resources\CommonCollection;

class RolesController extends Controller
{
    public function index()
    {
        return new CommonCollection(Role::all());
    }
}
