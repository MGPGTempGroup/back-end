<?php

namespace App\Http\Requests\Admin;

class CreateCompanyDepartmentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }
}
