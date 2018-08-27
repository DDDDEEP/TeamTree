<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Libraries\CollectionFilter;
use App\Http\Resources\UserCollection;

class UsersController extends Controller
{
    public function index(UserRequest $request)
    {
        return new UserCollection(
            (new CollectionFilter(User::all()))->filterByRequest($request)
        );
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
