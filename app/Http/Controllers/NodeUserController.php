<?php

namespace App\Http\Controllers;

use App\Models\NodeUser;
use App\Http\Resources\NodeUserCollection;
use App\Http\Requests\NodeUserRequest;

class NodeUserController extends Controller
{
    public function index()
    {
        return new NodeUserCollection(NodeUser::all());
    }

    public function store(NodeUserRequest $request)
    {
        $node_user = new NodeUser;
        $node_user->node_id = $request->input('node_id');
        $node_user->user_id = $request->input('user_id');
        $node_user->role_id = $request->input('role_id');
        $this->authorize('store', $node_user);

        return ResponseJson(NodeUser::create($request->all()));
    }

    public function update(NodeUserRequest $request, NodeUser $node_user)
    {
        $this->authorize($node_user);
        $model = NodeUser::findOrFail($node_user->id);
        $model->update($request->all());
        $model->update(array_except(
            $request->all(),
            ['id', 'node_id', 'user_id']
        ));

        return ResponseJson($model);
    }

    public function destroy(NodeUserRequest $request, NodeUser $node_user)
    {
        $this->authorize('destroy', $node_user);
        $model = NodeUser::findOrFail($node_user->id);
        $model->delete();

        return ResponseJson();
    }
}
