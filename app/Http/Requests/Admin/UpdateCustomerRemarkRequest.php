<?php

namespace App\Http\Requests\Admin;

class UpdateCustomerRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'string'
        ];
    }
}
