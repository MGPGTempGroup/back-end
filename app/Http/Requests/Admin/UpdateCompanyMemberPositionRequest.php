<?php

namespace App\Http\Requests\Admin;

class UpdateCompanyMemberPositionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'department_id' => 'exists:company_departments,id'
        ];
    }
}
