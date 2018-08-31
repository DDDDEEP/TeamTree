<?php

namespace App\Http\Requests;

use App\Models\Node;
use Illuminate\Validation\Rule;

class NodeRequest extends Request
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
                    'project_id' => 'bail|required|integer|exists:projects,id',
                    'parent_id'  => 'bail|required|integer|exists:nodes,id',
                    'name'       => 'bail|required',
                    'height'     => 'bail|required|integer',
                    'status'     => 'bail|required|integer',
                ];
                break;
            // UPDATE
            case 'PUT':
            case 'PATCH':
                switch ($route_name) {
                    case 'nodes.update.update_status':
                        $rules = [
                            'status' => 'integer|required',
                        ];
                        break;
                    default:
                        $rules = [
                            'project_id' => 'bail|integer|exists:projects,id',
                            'parent_id'  => 'bail|integer|exists:nodes,id',
                            'name'       => 'bail|filled',
                            'height'     => 'bail|integer',
                            'status'     => 'bail|integer',
                        ];
                }
                break;
            case 'DELETE':
            default:
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'parent_id.exists' => '父节点不存在',
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
                'node',
                ['parent_id', 'height']
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
                    // 检验高度是否正确
                    if ($data['parent_id'] != null
                        && Node::find($data['parent_id'])->height != $data['height'] - 1) {
                        $validator->errors()->add('height', '高度数据有误');
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