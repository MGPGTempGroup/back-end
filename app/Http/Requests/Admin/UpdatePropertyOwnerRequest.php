<?php

namespace App\Http\Requests\Admin;

class UpdatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|string|unique:property_owners',
            'surname' => 'string',
            'phone' => 'bail|string|unique:property_owners',
            'email' => 'bail|string|unique:property_owners',
            'wechat' =>'bail|string|unique:property_owners',
            'address' => 'string',
            'id_card' => 'bail|string|unique:property_owners',
            'identity_id' => 'bail|exists:customer_identities,id'
        ];
    }
}
