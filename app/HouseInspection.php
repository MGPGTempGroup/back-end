<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseInspection extends Model
{
    use SoftDeletes;

    protected $table = 'house_inspections';

    protected $fillable = [
        'surname',
        'first_name',
        'mobile',
        'email',
        'comment',
        'mobile_from_country',
        'preferred_inspection_datetime',
        'preferred_move_in_date'
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

    /**
     * 跟进人关联关系
     */
    public function followUp()
    {
        return $this->belongsTo(AdminUser::class, 'follow_up', 'id');
    }

    /**
     * 备注关联关系
     */
    public function remarks()
    {
        return $this->morphMany('App\Remark', 'come_from');
    }

}
