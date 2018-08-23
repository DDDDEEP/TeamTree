<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Project;

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
        // to show projects
        // $projects = Auth::user()->projects()->first()->pivot;
        // $projects = $projects->project;
        // dd(Auth::user()->projects());
        $projects = Auth::user()->projects->first()->pivot->created_at;
        return view('resources/home',compact('projects'));
    }

    public function showTree(Project $project)
    {
        $tree = $project->getTree();
        return view('resources/tree', compact('tree'));
    }
}
