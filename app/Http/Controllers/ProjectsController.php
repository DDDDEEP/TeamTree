<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\Role;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Libraries\CollectionFilter;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\CommonCollection;

class ProjectsController extends Controller
{
    public function index(ProjectRequest $request)
    {
        return new CommonCollection(
            (new CollectionFilter(Project::all()))->filterByRequest($request)
        );
    }

    public function getTree(ProjectRequest $request, Project $project)
    {
        return ResponseJson($project->getTree($request->input('user_id'), null));
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());
        Node::create([
            'project_id' => $project->id,
            'parent_id' => null,
            'name' => '根节点',
            'height' => 1,
            'status' => 1,
            'description' => '项目新建完成，尝试添加节点任务吧！',
        ]);
        ProjectUser::create([
            'project_id' => $project->id,
            'user_id' => Auth::user()->id,
            'role_id' => Role::where('level', 6)->first()->id,
            'status' => 1,
        ]);


        return ResponseJson($project);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize($project);
        $model = Project::findOrFail($project->id);
        $model->update(array_except(
            $request->all(),
            ['id', ]
        ));

        return ResponseJson($model);
    }

    public function destroy(ProjectRequest $request, Project $project)
    {
        $this->authorize('destroy', $project);
        $model = Project::findOrFail($project->id);
        $model->deleteAll();

        return ResponseJson();
    }
}
