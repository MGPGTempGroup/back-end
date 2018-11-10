<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateResidenceRequest;
use App\Http\Requests\Admin\UpdateResidenceRequest;
use App\Http\Response\Transformers\Admin\ResidenceTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Residence;

class ResidenceController extends Controller
{

    /**
     * 获取出售房屋数据列表
     */
    public function index(Request $request, Residence $residence)
    {
        $pageSize = (int)$request->pagesize ?: 20;
        return $this->response->paginator($residence->paginate($pageSize), new ResidenceTransformer());
    }

    /**
     * 展示出售房屋详情数据
     */
    public function show(Residence $residence)
    {
        return $this->response->item($residence, new ResidenceTransformer());
    }

    /**
     * 创建出售房屋数据
     */
    public function store(CreateResidenceRequest $request, Residence $residence)
    {
        $residence->fill($request->all());
        $residence->save();
        $residence->propertyType()->attach($request->property_type_id);
        return $this->response->item($residence, new ResidenceTransformer());
    }

    /**
     * 修改出售房屋数据
     */
    public function update(UpdateResidenceRequest $request, Residence $residence)
    {
        $residence->fill($request->all());
        $residence->save();
        if ($request->property_type_id) {
            $residence->propertyType()->sync($request->property_type_id);
        }
        return $this->response->item($residence, new ResidenceTransformer());
    }

    /**
     * 软删除出售房屋数据
     */
    public function destroy(Residence $residence)
    {
        $residence->delete();
        return $this->response->noContent();
    }

}