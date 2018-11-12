<?php

namespace App\Policies\Admin;

use App\AdminUser;
use App\CustomerRemark;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerRemarkPolicy
{
    use HandlesAuthorization;

    /**
     * 检查当前管理员用户是否有权修改当前客户标记
     */
    public function update(AdminUser $adminUser, CustomerRemark $customerRemark)
    {
        return $adminUser->id === $customerRemark->admin_user_id;
    }

    /**
     * 检查当前管理员用户是否有权软删除当前客户标记
     */
    public function delete(AdminUser $adminUser, CustomerRemark $customerRemark)
    {
        return $adminUser->id === $customerRemark->admin_user_id;
    }
}
