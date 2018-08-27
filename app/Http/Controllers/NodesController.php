<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Http\Requests\NodeRequest;
use App\Libraries\CollectionFilter;
use App\Http\Resources\CommonCollection;

class NodesController extends Controller
{
    public function index()
    {
        return new CommonCollection(
            (new CollectionFilter(Node::all()))->filterByRequest($request)
        );
    }

    public function store(NodeRequest $request)
    {
        $parent = Node::findOrFail($request->input('parent_id'));
        $this->authorize('store', $parent);

        return ResponseJson(Node::create($request->all()));
    }

    public function update(NodeRequest $request, Node $node)
    {
        $this->authorize($node);
        $model = Node::findOrFail($node->id);
        $model->update(array_except(
            $request->all(),
            ['id', 'project_id', 'parent_id', 'height']
        ));

        return ResponseJson($model);
    }

    public function updateStatus(NodeRequest $request, Node $node)
    {
        $this->authorize($node);
        $model = Node::findOrFail($node->id);
        $model->update(['status' => $request->input('status')]);

        return ResponseJson($model);
    }

    public function destroy(NodeRequest $request, Node $node)
    {
        $this->authorize('destroy', $node);
        $model = Node::findOrFail($node->id);
        $model->deleteAll();

        return ResponseJson([], '', $model->isRoot() ? '根节点不会被删除' : '');
    }
}
