<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{

    protected $fillable = [
        'content',
        'come_from_type',
        'come_from_id'
    ];

    /**
     * 多态关联
     */
    public function comeFrom()
    {
        return $this->morphTo();
    }

    /*
     * 创建者关联关系
     */
    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }

}
