<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Http\Resources\ProjectUserCollection;
use App\Http\Requests\ProjectUserRequest;

class ProjectUserController extends Controller
{
    public function index(ProjectUserRequest $request)
    {
        return new ProjectUserCollection(ProjectUser::all());
    }

    public function store(ProjectUserRequest $request)
    {
        $project_user = new ProjectUser;
        $project_user->project_id = $request->input('project_id');
        $project_user->user_id = $request->input('user_id');
        $project_user->role_id = $request->input('role_id');
        $this->authorize('store', $project_user);

        return ResponseJson(ProjectUser::create($request->all()));
    }

    public function update(ProjectUserRequest $request, ProjectUser $project_user)
    {
        $this->authorize($project_user);
        $model = ProjectUser::findOrFail($project_user->id);
        $model->update(array_except(
            $request->all(),
            ['id', 'project_id', 'user_id']
        ));

        return ResponseJson($model);
    }

    public function destroy(ProjectUserRequest $request, ProjectUser $project_user)
    {
        $this->authorize('destroy', $project_user);
        $model = ProjectUser::findOrFail($project_user->id);
        $model->deleteAll();

        return ResponseJson();
    }
}
