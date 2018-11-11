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
            'phone' => 'bail|string|required_without_all:email,wechat',
            'email' => 'bail|string|email|required_without_all:phone,wechat',
            'wechat' => 'bail|string|required_without_all:phone,email',
            'address' => 'string'
        ];
    }
}
