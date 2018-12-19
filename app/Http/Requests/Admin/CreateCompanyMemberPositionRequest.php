<?php

namespace App\Http\Requests\Admin;

class CreateCompanyMemberPositionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'positions' => 'array'
        ];
    }
}
