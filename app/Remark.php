<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{

    protected $fillable = ['content'];

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
