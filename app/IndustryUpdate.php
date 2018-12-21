<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustryUpdate extends Model
{
    protected $fillable = [
        'title',
        'content',
        'first_picture',
        'top_picture'
    ];

    /**
     * 创建者关联关系
     */
    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }
}
