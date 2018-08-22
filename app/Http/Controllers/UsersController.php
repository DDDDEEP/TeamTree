<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\CommonCollection;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function index()
    {
        return new CommonCollection(User::all());
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize($user);
        $model = User::findOrFail($user->id);
        $model->update(array_except(
            $request->all(),
            ['id', 'password']
        ));

        return ResponseJson($model);
    }
}
