<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Node;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Http\Resources\CommonCollection;
use App\Http\Requests\ProjectRequest;

class ProjectsController extends Controller
{
    public function index()
    {
        return new CommonCollection(Project::all());
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());
        Node::create([
            'project_id' => $project->id,
            'parent_id' => null,
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
