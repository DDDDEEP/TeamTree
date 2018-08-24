<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\ProjectUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resources/home');
    }

    public function showTree(Project $project)
    {
        $tree = $project->getTree(Auth::user()->id);
        $user = Auth::user();
        return view('resources/tree', compact('tree', 'project', 'user'));
    }

    public function showProject()
    {
        $pro = Auth::user()->projects;
        // 下面這個獲得的是關係表
        // dd($projects);
        $projects = array();
        foreach($pro as $project) {
            $item = Project::find($project->pivot->project_id);
            array_push($projects,$item);
        }
        return view('resources/project',compact('projects'));
    }

    public function showInfo(Project $project)
    {
        $project_users = ProjectUser::with(['user', 'role'])
            ->where('project_id', $project->id)
            ->get();
        $roles = $project->getAllRoles();
        return view('resources/project_info', compact('project', 'project_users', 'roles'));
    }
}
