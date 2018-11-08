<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['content', 'broadcast_pictures'];

    public function scopeByName($query, $serviceName)
    {
        return $query->where('name', strtolower($serviceName));
    }

    /**
     * Relation: Service - ServiceMessage
     */
    public function messages()
    {
        return $this->hasMany(ServiceMessage::class, 'service_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

}
