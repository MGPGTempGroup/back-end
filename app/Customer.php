<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'surname', 'email', 'phone', 'wechat', 'address', 'identity_id'];

    /**
     * 客户身份关联关系
     */
    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'identity_id', 'id');
    }

    /**
     * 负责客户的公司成员关联关系
     */
    public function members()
    {
        return $this->belongsToMany(
            CompanyMember::class,
            'customer_member',
            'customer_id',
            'member_id')->withTimestamps();
    }

    /**
     * 备注关联关系
     */
    public function remarks()
    {
        return $this->morphMany('App\Remark', 'come_from');
    }

}
