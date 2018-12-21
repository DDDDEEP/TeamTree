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

    public function show(UserRequest $request, User $user)
    {
        return view('resources/user_info', compact('user'));
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

    public function showPassword(UserRequest $request, User $user)
    {
        $this->authorize($user);
        return view('resources/user_password', compact('user'));
    }

    public function updatePassword(UserRequest $request, User $user)
    {
        $this->authorize($user);
        $model = User::findOrFail($user->id);
        if (!password_verify($request->old_password, $model->password)) {
            return ResponseJson([], '密码错误');
        }
        $model->update([
            'password' => bcrypt($request->new_password)
        ]);

        return ResponseJson($model);
    }

}
