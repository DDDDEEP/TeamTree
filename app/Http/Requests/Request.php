<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $key_errors = $validator->errors()->all();
        throw new HttpResponseException(ResponseJson([], implode('|', $key_errors)));
    }

    /**
     * 获取混合请求与模型字段值的数组，优先拿取请求值
     *
     * @param  string  $model_name  模型变量名
     * @param  arrray  $data_fields  字段名数组
     * @return array
     */
    protected function makeMixData($model_name, $data_fields)
    {
        $data = [];
        foreach ($data_fields as $field) {
            $data[$field] = $this->$field ? $this->$field : $this->$model_name->$field;
        }
        return $data;
    }
}