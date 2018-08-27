<?php

namespace App\Http\Controllers;

use App\Models\NodeUser;
use App\Libraries\CollectionFilter;
use App\Http\Requests\NodeUserRequest;
use App\Http\Resources\NodeUserCollection;

class NodeUserController extends Controller
{
    public function index(NodeUserRequest $request)
    {
        return new NodeUserCollection(
            (new CollectionFilter(NodeUser::all()))->filterByRequest($request)
        );
    }

    public function store(NodeUserRequest $request)
    {
        $node_user = new NodeUser;
        $node_user->node_id = $request->input('node_id');
        $node_user->user_id = $request->input('user_id');
        $node_user->role_id = $request->input('role_id');
        $this->authorize('store', $node_user);
        $node_user->deleteChildren($node_user->user_id);

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
        $node_user->deleteChildren($node_user->user_id);

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
