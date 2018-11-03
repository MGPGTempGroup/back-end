<?php

namespace App\Http\Requests\Admin;

class UpdateCompanyInfoRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_name' => 'string',
            'telephone' => 'string',
            'facsimile' => 'string',
            'address' => 'string',
            'post_code' => 'string',
            'regionalism_code' => 'string',
            'opening_hours' => 'string',
            'service_time' => 'string',
            'google_plus_homepage' => 'string|url',
            'linkin_homepage' => 'string|url',
            'youtube_homepage' => 'string|url',
            'facebook_homepage' => 'string|url',
            'twitter_homepage' => 'string|url',
            'instagram_homepage' => 'string|url'
        ];
    }
}
