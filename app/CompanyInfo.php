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

    public function getAddressAttribute()
    {
        return json_decode($this->attributes['address']);
    }

    public function setAddressAttribute($val)
    {
        return $this->attributes['address'] = json_encode($val);
    }

    public function getOpeningHoursAttribute()
    {
        return json_decode($this->attributes['opening_hours']);
    }

    public function setOpeningHoursAttribute($val)
    {
        return $this->attributes['opening_hours'] = json_encode($val);
    }

}
