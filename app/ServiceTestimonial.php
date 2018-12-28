<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTestimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'surname',
        'name',
        'email',
        'phone',
        'comment',
        'identity_id',
        'star_level'
    ];

    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'identity_id', 'id');
    }
}
