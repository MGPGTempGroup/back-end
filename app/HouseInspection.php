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
//        'house_type',
//        'house_id',
        'inspection_date',
        'inspection_time'
    ];

    public function house()
    {
        return $this->morphTo('house', 'house_type', 'house_id');
    }

    /**
     * 出售房屋查询作用域
     */
    public function scopeHouseType($query, $type = null)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'sale':
                return $query->where('house_type', Residence::class);
                break;
            case 'lease':
                return $query->where('house_type', Lease::class);
                break;
            default:
                return $query;
                break;
        }
    }

}
