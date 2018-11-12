<?php

namespace App\Policies\Admin;

use App\AdminUser;
use App\LeaseRemark;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaseRemarkPolicy
{
    use HandlesAuthorization;

    /**
     * 检查当前管理员用户是否有权修改当前租赁房屋备注
     */
    public function update(AdminUser $adminUser, LeaseRemark $leaseRemark)
    {
        return $adminUser->id === $leaseRemark->admin_user_id;
    }

    /**
     * 检查当前管理员用户是否有权软删除当前租赁房屋备注
     */
    public function delete(AdminUser $adminUser, LeaseRemark $leaseRemark)
    {
        return $adminUser->id === $leaseRemark->admin_user_id;
    }

}
