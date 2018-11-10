<?php

namespace App\Http\Requests\Admin;

class UpdateLeaseRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'required|string'
        ];
    }
}
