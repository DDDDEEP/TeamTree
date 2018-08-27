<?php

namespace App\Http\Requests;

use App\Models\PermissionRole;
use Illuminate\Validation\Rule;

class PermissionRoleRequest extends Request
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
                $rules = [
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
                '',
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