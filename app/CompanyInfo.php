<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{

    protected $table = 'company_info';

    protected $fillable =  [
        'company_name',
        'telephone',
        'facsimile',
        'address' ,
        'post_code' ,
        'regionalism_code',
        'opening_hours',
        'service_time',
        'google_plus_homepage',
        'linkin_homepage',
        'youtube_homepage',
        'facebook_homepage',
        'twitter_homepage',
        'instagram_homepage'
    ];

    /**
     * 获取最新数据
     */
    public function getLatest()
    {
        return $this->orderBy('id', 'DESC')->limit(1)->first() ?? $this;
    }

}
