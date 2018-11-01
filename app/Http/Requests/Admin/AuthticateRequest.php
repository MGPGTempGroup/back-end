<?php

namespace App\Http\Requests\Admin;

class AuthticateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'bail|required|email',
            'password' => 'required|string'
        ];
    }
}
