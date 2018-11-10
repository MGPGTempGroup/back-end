<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResidenceRemark extends Model
{
    use SoftDeletes;

    protected $fillable = ['admin_user_id', 'content', 'residence_id'];

    public function lease()
    {
        return $this->belongsTo(Residence::class, 'residence_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(AdminUser::class ,'admin_user_id', 'id');
    }
}
