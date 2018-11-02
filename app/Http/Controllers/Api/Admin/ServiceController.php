<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Http\Requests\Admin\CreateServiceAreaRequest;
use App\Http\Requests\Admin\UpdateServiceAreaRequest;

use App\Http\Response\Transformers\Admin\ServiceTransformer;
use App\Http\Response\Transformers\Admin\ServiceAreaTransformer;

use App\Service;
use App\ServiceArea;

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

    /**
     * 展示服务地区列表
     */
    public function showServiceAreas()
    {
        return $this->response->item(ServiceArea::get(), new ServiceTransformer());
    }

    /**
     * 展示服务地区详情
     */
    public function showServiceArea(ServiceArea $serviceArea)
    {
        return $this->response->item($serviceArea, new ServiceAreaTransformer());
    }

    /**
     * 创建服务地区
     */
    public function createServiceArea(CreateServiceAreaRequest $request, ServiceArea $serviceArea)
    {
        $serviceArea->fill($request->all());
        $serviceArea->save();

        return $this->response->item($serviceArea, new ServiceAreaTransformer());
    }

    /**
     * 修改服务地区
     */
    public function updateServiceArea(UpdateServiceAreaRequest $request, ServiceArea $serviceArea)
    {
        $serviceArea->fill($request->all());
        $serviceArea->save();

        return $this->response->item($serviceArea, new ServiceAreaTransformer());
    }
}
