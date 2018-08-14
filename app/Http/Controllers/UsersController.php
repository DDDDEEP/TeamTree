<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\CommonCollection;

class UsersController extends Controller
{
    public function index()
    {
        return new CommonCollection(User::all());
    }
}
