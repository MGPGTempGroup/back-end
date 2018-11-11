<?php

namespace App\Http\Requests\Admin;

class CreateCustomerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'surname' =>'bail|required|string',
            'identity_id' => 'bail|required|exists:customer_identities,id',
            'phone' => 'bail|required_without_all:email,wechat|string',
            'email' => 'bail|required_without_all:phone,wechat|string',
            'wechat' => 'bail|required_without_all:phone,email|string',
            'address' => 'string'
        ];
    }
}
