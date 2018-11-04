<?php

namespace App\Http\Requests\Admin;

class CreateCompanyMemberPositionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'department_id' => 'bail|required|exists:company_departments,id'
        ];
    }
}
