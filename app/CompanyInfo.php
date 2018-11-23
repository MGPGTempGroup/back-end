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
        'address',
        'detailed_address',
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

    public function getAddressAttribute($address)
    {
        return json_decode($address);
    }

    public function setAddressAttribute($address)
    {
        return $this->attributes['address'] = json_encode($address);
    }

    public function getOpeningHoursAttribute($openingHours)
    {
        return json_decode($openingHours);
    }

    public function setOpeningHoursAttribute($openingHours)
    {
        return $this->attributes['opening_hours'] = json_encode($openingHours);
    }

}
