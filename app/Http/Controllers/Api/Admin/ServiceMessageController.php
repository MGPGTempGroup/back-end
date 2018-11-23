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
     * 展示所有服务页面留言列表
     */
    public function index(Request $request, ServiceMessage $serviceMessage)
    {
        $messages = $this->buildEloquentQueryThroughQs($serviceMessage)->paginate();
        return $this->response->paginator($messages, new ServiceMessageTransformer());
    }

    /**
     * 展示某一服务下留言
     */
    public function show(Request $request, Service $service)
    {
        $messagesRelation = $service->messages()->with(['identity']);
        $messages = $this->buildEloquentQueryThroughQs($messagesRelation)->paginate();
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
