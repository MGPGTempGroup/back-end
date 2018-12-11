<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseInspection extends Model
{
    protected $table = 'house_inspections';

    public function house()
    {
        return $this->morphTo('house', 'house_type', 'house_id');
    }

}
