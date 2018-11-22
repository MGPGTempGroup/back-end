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
            'address' => 'array',
            'detailed_address' => 'string',
            'post_code' => 'string',
            'regionalism_code' => 'string',
            'opening_hours' => 'array',
//            'service_time' => 'string',
            'google_plus_homepage' => 'nullable|string|url',
            'linkin_homepage' => 'nullable|string|url',
            'youtube_homepage' => 'nullable|string|url',
            'facebook_homepage' => 'nullable|string|url',
            'twitter_homepage' => 'nullable|string|url',
            'instagram_homepage' => 'nullable|string|url'
        ];
    }
}
