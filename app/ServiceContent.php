<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceContent extends Model
{
    protected $fillable = [
        'content',
        'broadcast_pictures'
    ];

    public function setBroadcastPicturesAttribute($value)
    {
        return $this->setAttribute('broadcast_pictures', json_encode($value));
    }

    public function getBroadcastPicturesAttribute($value)
    {
        return json_decode($value);
    }

}
