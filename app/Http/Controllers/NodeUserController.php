<?php

namespace App\Http\Controllers;

use App\Models\NodeUser;
use App\Http\Resources\CommonCollection;

class NodeUserController extends Controller
{
    public function index()
    {
        return new CommonCollection(NodeUser::all());
    }
}
