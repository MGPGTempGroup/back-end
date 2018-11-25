<?php

namespace App\Http\Requests\Admin;

use App\CompanyMemberPosition;

class UpdateCompanyMemberRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'google_plus_homepage' => 'url',
            'linkin_homepage' => 'url',
            'introduction' => 'string',
            'photo' => 'string', // image key
            'thumbnail' => 'string', // image key
            'positions' => 'array'
        ];
    }
}
