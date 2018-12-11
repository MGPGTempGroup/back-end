<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseInspection extends Model
{
    protected $table = 'house_inspections';

    protected $fillable = [
        'surname',
        'first_name',
        'mobile',
        'comment',
        'house_type',
        'house_id',
        'inspection_date',
        'inspection_time'
    ];

    public function house()
    {
        return $this->morphTo('house', 'house_type', 'house_id');
    }

}
