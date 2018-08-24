<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\NodeUserNotExist;
use App\Rules\HigherMixNodeRole;
use App\Models\Role;
use App\Models\User;

class NodeUserRequest extends Request
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
                    'node_id'  => [
                        'bail',
                        'required',
                        'integer',
                        'exists:nodes,id',
                        Rule::unique('node_user')->where(function ($query) {
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
                            $query->whereIn('level', [2, 3, 4]);
                        }),
                    ]
                ];
                break;
            // UPDATE
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'node_id'  => 'bail|integer|exists:nodes,id',
                    'user_id'  => 'bail|integer|exists:users,id',
                    'role_id'  => [
                        'bail',
                        'integer',
                        'exists:roles,id',
                        Rule::exists('roles', 'id')->where(function ($query) {
                            $query->whereIn('level', [2, 3, 4]);
                        }),
                    ]
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
            'node_id.unique' => '对应记录已经存在',
            'role_id.exists' => '角色不存在或不能作为node_user.role_id',
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
                'node_user',
                ['node_id', 'user_id', 'role_id']
            );
            $role = Role::find($data['role_id']);
            $user = User::find($data['user_id']);
            $user_role = $user->getNodeRole($data['node_id']);

            // 检验对应用户节点角色是否存在，若不存在，说明对应用户不属于该项目
            if (!$user_role) {
                $validator->errors()->add('role_id', '用户不属于该项目');
                return;
            }

            switch ($this->method()) {
                // INDEX
                case 'GET':
                    break;
                // CREATE
                case 'POST':
                    // 检验添加的角色是否大于用户的节点角色等级
                    if ($role->level <= $user_role->level) {
                        $validator->errors()->add('role_id', '添加的角色的等级应大于该用户对于节点角色等级');
                    }
                    break;
                // UPDATE
                case 'PUT':
                case 'PATCH':
                    // 检验添加的角色是否大于等于用户的节点角色等级
                    if ($role->level < $user_role->level) {
                        $validator->errors()->add('role_id', '编辑的角色的等级应大于等于该用户对于节点角色等级');
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
