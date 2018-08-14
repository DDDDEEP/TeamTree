<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Http\Resources\CommonCollection;

class NodesController extends Controller
{
    public function index()
    {
        return new CommonCollection(Node::all());
    }
}
