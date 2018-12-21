<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserRequest extends Request
{
    public function rules()
    {
        $rules = [];
        $route_name = $this->route()->getName();

        switch ($this->method()) {
            // INDEX
            case 'GET':
                break;
            // CREATE
            case 'POST':
                $rules = [
                ];
                break;
            // UPDATE
            case 'PUT':
            case 'PATCH':
                switch ($route_name) {
                    case 'users.update.update_password':
                        $rules = [
                            'old_password' => 'required|between:6,18',
                            'new_password' => 'required|between:6,18',
                        ];
                        break;
                    default:
                    $rules = [
                        'name'  => 'bail|filled|unique:users,name,'.$this->user->id.',id',
                        'email'  => 'bail|email|filled|unique:users,email,'.$this->user->id.',id',
                        'sex'  => 'bail|integer',
                    ];
                }
                break;
            case 'DELETE':
            default:
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }

    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $is_failed = $validator->fails();

        $validator->after(function () use ($validator, $is_failed) {
            if ($is_failed) {
                return;
            }

            $data = $this->makeMixData(
                'user',
                []
            );
            switch ($this->method()) {
                // INDEX
                case 'GET':
                    break;
                // CREATE
                case 'POST':
                // UPDATE
                case 'PUT':
                case 'PATCH':
                    break;
                case 'DELETE':
                default:
                    break;
            }
        });

        return $validator;
    }
}