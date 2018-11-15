<?php

namespace App\Http\Requests\Admin;

class CreatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|string|unique:property_owners',
            'surname' => 'required|string',
            'phone' => 'bail|required_without_all:email,wechat|unique:property_owners',
            'email' => 'bail|required_without_all:phone,wechat|unique:property_owners',
            'wechat' =>'bail|required_without_all:phone,email|unique:property_owners',
            'address' => 'string',
            'id_card' => 'string|unique:property_owners',
            'identity_id' => 'bail|required|exists:customer_identities,id'
        ];
    }
}
