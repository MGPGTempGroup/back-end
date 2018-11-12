<?php

namespace App\Policies\Admin;

use App\ResidenceRemark;
use App\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResidenceRemarkPolicy
{
    use HandlesAuthorization;

    /**
     * 检查当前管理员用户是否有权修改当前出售房屋备注
     */
    public function update(AdminUser $adminUser, ResidenceRemark $residenceRemark)
    {
        return $adminUser->id === $residenceRemark->admin_user_id;
    }

    /**
     * 检查当前管理员用户是否有权软删除当前出售房屋备注
     */
    public function delete(AdminUser $adminUser, ResidenceRemark $residenceRemark)
    {
        return $adminUser->id === $residenceRemark->admin_user_id;
    }
}
