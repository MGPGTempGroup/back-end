<?php

namespace App\Http\Requests\Admin;

class CreatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'phone' => 'bail|required|string|unique:property_owners,phone',
            'email' => 'bail|required|string|email|unique:property_owners,email',
            'address' => 'string'
        ];
    }
}
