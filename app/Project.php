<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['name', 'location', 'address', 'status', 'introduction', 'description', 'year_built', 'broadcast_pictures'];

    /**
     * 项目产品类型关联关系
     */
    public function productTypes() {
        return $this->belongsToMany(
            ProductType::class,
            'project_product_type',
            'project_id',
            'product_type_id')->withTimestamps();
    }

    /**
     * 项目代理关联关系
     */
    public function agents()
    {
        return $this->belongsToMany(
            CompanyMember::class,
            'project_agent',
            'project_id',
            'member_id')->withTimestamps();
    }

    public function getAddressAttribute($address)
    {
        return json_decode($address);
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = json_encode($address);
    }

}
