<?php

namespace App\Http\Requests\Admin;

class UpdatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'phone' => 'unique:property_owners',
            'email' => 'unique:property_owners',
            'status' => 'in:0,1,2,3,4',
            'address' => 'string'
        ];
    }
}
