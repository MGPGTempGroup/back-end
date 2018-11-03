<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMemberPosition extends Model
{
    /**
     * 职位 - 部门关联关系
     */
    public function department()
    {
        return $this->belongsTo(CompanyDepartment::class, 'department_id', 'id');
    }
}
