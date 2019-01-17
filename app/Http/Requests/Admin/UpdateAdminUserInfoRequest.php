<?php

namespace App\Http\Requests\Admin;

class UpdateAdminUserInfoRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'avatar' => 'bail|string|url',
            'name' => 'string|max:191',
            'email' => 'string|max:191'
        ];
    }
}
