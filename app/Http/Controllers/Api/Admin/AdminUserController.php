<?php

namespace App\Http\Controllers\Api\Admin;

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
     * 获取当前管理员通知
     */
    public function notifications(Request $request)
    {
        $pageSize = $request->query('pagesize') ?: 20;
        $notifications = $this->user()->notifications()->paginate($pageSize);
        return $this->response->paginator($notifications, new AdminUserNotificationTransformer());
    }
}
