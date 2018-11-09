<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\ServiceMessageTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ServiceMessage;
use App\Service;

class ServiceMessageController extends Controller
{

    /**
     * 展示服务页面留言列表
     */
    public function index(Request $request, ServiceMessage $serviceMessage)
    {
        $pageSize = (int) $request->pagesize ?? 20;
        $messages = $serviceMessage->paginate($pageSize);
        return $this->response->paginator($messages, new ServiceMessageTransformer());
    }

    /**
     * 通过id展示某一留言详情
     */
    public function show(Request $request, Service $service)
    {
        $pageSize = (int) $request->pagesize ?? 20;
        $messages = $service->messages()->with(['identity'])->paginate($pageSize);
        return $this->response->paginator($messages, new ServiceMessageTransformer());
    }

    /**
     * 软删除留言
     */
    public function delete(ServiceMessage $serviceMessage)
    {
        $serviceMessage->delete();
        return $this->response->noContent();
    }

}
