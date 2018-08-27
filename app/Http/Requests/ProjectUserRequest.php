<?php

namespace App\Http\Requests;

use App\Models\ProjectUser;
use Illuminate\Validation\Rule;

class ProjectUserRequest extends Request
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
                    'project_id'  => [
                        'bail',
                        'required',
                        'integer',
                        'exists:projects,id',
                        Rule::unique('project_user')->where(function ($query) {
                            $query->where('user_id', $this->user_id);
                        }),
                    ],
                    'user_id'  => 'bail|required|integer|exists:users,id',
                    'role_id'  => [
                        'bail',
                        'required',
                        'integer',
                        'exists:roles,id',
                        Rule::exists('roles', 'id')->where(function ($query) {
                            $query->whereNotIn('level', [6]);
                        }),
                    ],
                    'status'  => 'bail|required|integer',
                ];
                break;
            // UPDATE
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'project_id'  => 'bail|integer|exists:projects,id',
                    'user_id'  => 'bail|integer|exists:users,id',
                    'role_id'  => [
                        'bail',
                        'integer',
                        'exists:roles,id',
                        Rule::exists('roles', 'id')->where(function ($query) {
                            $query->whereNotIn('level', [6]);
                        }),
                    ],
                    'status'  => 'bail|integer',
                ];
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
            'project_id.unique' => '对应记录已经存在',
            'role_id.exists' => '角色不存在或不能为项目创始人',
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
                'project_user',
                []
            );
            switch ($this->method()) {
                // INDEX
                case 'GET':
                    break;
                // CREATE
                case 'POST':
                    break;
                // UPDATE
                case 'PUT':
                case 'PATCH':
                    // 检验编辑的用户是否为项目创始人
                    if ($this->project_user->role->level == 6) {
                        $validator->errors()->add('role_id', '不能修改项目创始人的项目角色');
                    }
                    break;
                case 'DELETE':
                default:
                    break;
            }
        });

        return $validator;
    }
}