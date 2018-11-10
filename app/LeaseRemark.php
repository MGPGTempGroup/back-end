<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaseRemark extends Model
{
    protected $fillable = ['admin_user_id', 'content', 'lease_id'];

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(AdminUser::class ,'admin_user_id', 'id');
    }

}
