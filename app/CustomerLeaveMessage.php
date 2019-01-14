<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerLeaveMessage extends Model
{
    use SoftDeletes;

    protected $casts = [
        'messages' => 'array'
    ];

    public function remarks()
    {
        return $this->morphMany(Remark::class, 'come_from');
    }

}
