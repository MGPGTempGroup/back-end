<?php

namespace App\Http\Requests\Admin;

class CreateCustomerRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'required|string'
        ];
    }
}
