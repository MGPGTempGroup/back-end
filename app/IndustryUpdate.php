<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndustryUpdate extends Model
{

    use SoftDeletes;

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
