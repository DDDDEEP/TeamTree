<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\HeightIsRight;
use App\Models\Project;

class ProjectRequest extends Request
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
                    'name'  => 'bail|required|filled',
                ];
                break;
            // UPDATE
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name'  => 'bail|filled',
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
                'project',
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
                    break;
                case 'DELETE':
                default:
                    break;
            }
        });

        return $validator;
    }
}