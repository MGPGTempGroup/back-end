<?php

namespace App\Policies\Admin;

use App\AdminUser;
use App\Remark;
use Illuminate\Auth\Access\HandlesAuthorization;

class RemarkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the remark.
     *
     * @param  \App\AdminUser  $user
     * @param  \App\Remark  $remark
     * @return mixed
     */
    public function update(AdminUser $user, Remark $remark)
    {
        return $remark->creator_id === $user->id;
    }

    /**
     * Determine whether the user can delete the remark.
     *
     * @param  \App\AdminUser  $user
     * @param  \App\Remark  $remark
     * @return mixed
     */
    public function delete(AdminUser $user, Remark $remark)
    {
        return $remark->creator_id === $user->id;
    }

}
