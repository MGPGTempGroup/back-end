<?php

namespace App\Http\Requests\Admin;

class UpdateCustomerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'surname' =>'string',
            'identity_id' => 'exists:customer_identities,id',
            'phone' => 'string',
            'email' => 'string|email',
            'wechat' => 'string',
            'address' => 'string'
        ];
    }
}
