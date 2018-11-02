<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ServiceUpdateRequest;
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
        $service = Service::byName($request->service)->first();

        return $this->response->item($service, new ServiceTransformer());
    }

    /**
     * 修改服务内容
     */
    public function update(ServiceUpdateRequest $request)
    {
        $service = Service::byName($request->service)->first();

        $service->fill($request->all());
        $service->save();

        return $this->response->item($service, new ServiceTransformer());
    }
}
