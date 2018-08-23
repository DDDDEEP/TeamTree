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

    public function showInfo(Project $project)
    {
        $project_users = ProjectUser::with(['user', 'role'])
            ->where('project_id', $project->id)
            ->get();
        $roles = $project->getAllRoles();
        return view('resources/project_info', compact('project', 'project_users', 'roles'));
    }
}
