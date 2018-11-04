<?php

namespace App\Http\Requests\Admin;

class UpdateCompanyDepartmentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string'
        ];
    }
}
