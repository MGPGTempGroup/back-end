<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    protected $fillable = ['name', 'department_id'];

    /**
     * 部门 - 职位关联关系
     */
    public function positions()
    {
        return $this->hasMany(CompanyMemberPosition::class, 'department_id', 'id');
    }
}
