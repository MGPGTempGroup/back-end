<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Http\Requests\Admin\CreateServiceAreaRequest;
use App\Http\Requests\Admin\UpdateServiceAreaRequest;

use App\Http\Response\Transformers\Admin\ServiceTransformer;
use App\Http\Response\Transformers\Admin\ServiceAreaTransformer;

use App\Service;
use App\ServiceArea;

class ServiceController extends Controller
{

    /**
     * 展示服务列表
     */
    public function index(Service $service)
    {
        $services = $service->get();
        return $this->response->collection($services, new ServiceTransformer());
    }

    /**
     * 展示服务相关内容
     */
    public function show(Request $request, Service $service)
    {
        return $this->response->item($service, new ServiceTransformer());
    }

    /**
     * 修改服务内容
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->fill($request->all());
        $service->save();
        if ($request->members) {
            $service->members()->sync($request->members);
        }
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

    /**
     * 删除服务地区
     */
    public function destroyServiceArea(ServiceArea $serviceArea)
    {
        $serviceArea->delete();
        return $this->response->noContent();
    }
}
