<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Http\Response\Transformers\Admin\AdminUserNotificationTransformer;
use App\Http\Response\Transformers\Admin\AdminUserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{

    /**
     * 展示当前管理员信息
     */
    public function show()
    {
        return $this->response->item($this->user, new AdminUserTransformer());
    }

    /**
     * 修改个人信息
     */
    public function update(UpdateAdminUserRequest $request)
    {
        $user = auth('api')->user();
        $user->fill($request->only([
            'email',
            'name'
        ]));
        $user->save();

        return $this->response->item($user, new AdminUserTransformer());
    }

    /**
     * 获取当前管理员通知
     */
    public function notifications(Request $request)
    {
        $pageSize = $request->query('pagesize') ?: 20;
        $notifications = $this->user()->notifications()->paginate($pageSize);
        return $this->response->paginator($notifications, new AdminUserNotificationTransformer());
    }
}
