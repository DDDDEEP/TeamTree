<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Http\Resources\CommonCollection;

class ProjectUserController extends Controller
{
    public function index()
    {
        return new CommonCollection(ProjectUser::all());
    }
}
