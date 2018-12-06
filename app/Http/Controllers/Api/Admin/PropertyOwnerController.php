<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreatePropertyOwnerRequest;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UpdatePropertyOwnerRequest;
use App\Http\Response\Transformers\Admin\PropertyOwnerTransformer;
use App\PropertyOwner;
use Illuminate\Http\Request;

class PropertyOwnerController extends Controller
{
    /**
     * 展示物业业主列表
     */
    public function index(Request $request, PropertyOwner $propertyOwner)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($propertyOwner);

        // 如果存在searchByFullName参数则根据Full Name模糊查询
        if ($fullName = $request->query('searchByFullName')) {
            $owners = $eloquentBuilder
                ->whereRaw('concat(name, surname) like ?', ['%' . $fullName . '%'])
                ->get();
            return $this->response->collection($owners, new PropertyOwnerTransformer());
        }

        $owners = $eloquentBuilder->paginate();
        return $this->response->paginator($owners, new PropertyOwnerTransformer());
    }

    /**
     * 展示物主详情
     */
    public function show(PropertyOwner $propertyOwner)
    {
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer());
    }

    /**
     * 创建物业业主
     */
    public function store(CreatePropertyOwnerRequest $request, PropertyOwner $propertyOwner)
    {
        $propertyOwner->fill($request->all());
        $propertyOwner->save();
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer())->setStatusCode(201);
    }

    /**
     * 修改物业业主
     */
    public function update(UpdatePropertyOwnerRequest $request, PropertyOwner $propertyOwner)
    {
        $propertyOwner->fill($request->all());
        $propertyOwner->save();
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer());
    }

    /**
     * 删除物业业主
     */
    public function destroy(PropertyOwner $propertyOwner)
    {
        $propertyOwner->delete(); // 软删除
        return $this->response->noContent();
    }
}
