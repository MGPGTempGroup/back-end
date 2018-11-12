<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRemark extends Model
{
    use SoftDeletes;

    protected $fillable = ['admin_user_id', 'customer_id', 'content'];

    /**
     * 所属客户管理关系
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * 备注创建者关联关系
     */
    public function creator()
    {
        return $this->belongsTo(AdminUser::class ,'admin_user_id', 'id');
    }

}
