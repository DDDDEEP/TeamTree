<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\CommonCollection;

class ProjectsController extends Controller
{
    public function index()
    {
        return new CommonCollection(Project::all());
    }
}
