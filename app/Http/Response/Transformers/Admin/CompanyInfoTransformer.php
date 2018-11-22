<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\CompanyInfo;

class CompanyInfoTransformer extends TransformerAbstract
{
    public function transform(CompanyInfo $companyInfo)
    {
        return [
            'company_name' => $companyInfo->company_name,
            'telephone' => $companyInfo->telephone,
            'facsimile' => $companyInfo->facsimile,
            'address' => $companyInfo->address,
            'post_code' => $companyInfo->post_code,
            'regionalism_code' => $companyInfo->regionalism_code,
            'opening_hours' => $companyInfo->opening_hours,
            'detailed_address' => $companyInfo->detailed_address,
            'service_time' => $companyInfo->service_time,
            'google_plus_homepage' => $companyInfo->google_plus_homepage,
            'linkin_homepage' => $companyInfo->linkin_homepage,
            'youtube_homepage' => $companyInfo->youtube_homepage,
            'facebook_homepage' => $companyInfo->facebook_homepage,
            'twitter_homepage' => $companyInfo->twitter_homepage,
            'instagram_homepage' => $companyInfo->instagram_homepage
        ];
    }
}
