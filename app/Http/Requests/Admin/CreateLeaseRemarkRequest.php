<?php

namespace App\Http\Requests\Admin;

class CreateLeaseRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'admin_user_id' => 'bail|required|exists:admin_users,id',
            'content' => 'bail|required|string'
        ];
    }
}
