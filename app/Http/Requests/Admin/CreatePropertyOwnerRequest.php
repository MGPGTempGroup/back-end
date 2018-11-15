<?php

namespace App\Http\Requests\Admin;

class CreatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required_without:surname|nullable|string|unique:property_owners',
            'surname' => 'required_without:name|string|nullable',
            'phone' => 'bail|nullable|required_without_all:email,wechat|unique:property_owners',
            'email' => 'bail|nullable|required_without_all:phone,wechat|unique:property_owners',
            'wechat' =>'bail|nullable|required_without_all:phone,email|unique:property_owners',
            'address' => 'array',
            'id_card' => 'nullable|string|unique:property_owners',
            'identity_id' => 'bail|required|exists:customer_identities,id'
        ];
    }
}
