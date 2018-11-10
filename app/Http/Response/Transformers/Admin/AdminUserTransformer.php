<?php

namespace App\Http\Response\Transformers\Admin;

use App\AdminUser;
use League\Fractal\TransformerAbstract;

class AdminUserTransformer extends TransformerAbstract
{
    public function transform(AdminUser $adminUser)
    {
        return [
            'id' => $adminUser->id,
            'name' => $adminUser->name,
            'email' => $adminUser->email,
            'email_verified_at' => $adminUser->email_verified_at,
            'created_at' => $adminUser->created_at->toDateTimeString(),
            'updated_at' => $adminUser->updated_at->toDateTimeString()
        ];
    }
}
