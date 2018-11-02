<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Response\Transformers\Admin\ServiceTransformer;

use App\Service;

class ServiceController extends Controller
{
    /**
     * 展示服务相关内容
     */
    public function show(Request $request)
    {
        $serviceName = strtolower($request->service);
        $service = Service::where('name', $serviceName)->first();
        return $this->response->item($service, new ServiceTransformer);
    }
}
