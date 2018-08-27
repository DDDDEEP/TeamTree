<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\NodeUser;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Models\User;
use App\Models\Relationships;
use App\Libraries\CollectionFilter;
use App\Http\Resources\CommonCollection;

class TestController extends Controller
{
    public function index()
    {
        // dd(User::find(3)->getClosestNodeWithPivot(2));
        // dd(Role::find(1)->hasPermission('node.update.update_status'));
        // dd(User::find(1)->can('updateStatus', Node::find(1)));
        // dd(Node::find(1)->getDescendants());
        // dd(User::find(4)->isHigherThan(5, 1, 2));
        // dd(NodeUser::find(1)->node()->first());
        // dd(Node::find(1)->relationships());
        // dd((new Relationships(Node::with('project')->first()))->all());
        dd(NodeUser::find(1)->deleteChildren(4));
    }
}
