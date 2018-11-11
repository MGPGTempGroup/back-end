<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMember extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'photo', 'thumbnail', 'google_plus_homepage', 'linkin_homepage'];

    /**
     * 公司成员职位关联关系
     */
    public function positions()
    {
        return $this->belongsToMany(
            CompanyMemberPosition::class,
            'member_position',
            'member_id',
            'position_id')->withTimestamps();
    }

    /**
     * 成员所负责的客户关联关系
     */
    public function customers()
    {
        return $this->belongsToMany(
            Customer::class,
            'customer_member',
            'member_id',
            'customer_id')->withTimestamps();
    }

}
