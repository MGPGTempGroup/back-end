<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateResidenceRequest;
use App\Http\Requests\Admin\UpdateResidenceRequest;
use App\Http\Response\Transformers\Admin\ResidenceTransformer;
use App\ResidenceAgentPivot;
use App\ResidencePropertyTypePivot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Residence;

class ResidenceController extends Controller
{

    /**
     * 获取出售房屋数据列表
     */
    public function index(
        Request $request,
        Residence $residence,
        ResidenceAgentPivot $residenceAgentPivot,
        ResidencePropertyTypePivot $residencePropertyTypePivot)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($residence);

        // 判断是否包含公司成员（销售代理）id 条件查询参数
        if (is_array(($membersId = $request->query('members'))) && count($membersId)) {
            $residenceId = $residenceAgentPivot
                ->select('residence_id')
                ->whereIn('member_id', $membersId)
                ->pluck('residence_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $residenceId);
        }

        // 判断是否包含物业类型 id 条件查询参数
        if (is_array($propertyTypesId = $request->query('property_type')) && count($propertyTypesId) ) {
            $residenceId = $residencePropertyTypePivot
                ->select('residence_id')
                ->whereIn('property_type_id', $propertyTypesId)
                ->pluck('residence_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $residenceId);
        }

        $residences = $eloquentBuilder->paginate();
        return $this->response->paginator($residences, new ResidenceTransformer());
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
        $residence->creator_id = $this->user()->id;
        $residence->save();
        $residence->propertyType()->attach($request->input('property_type'));
        $residence->agents()->attach($request->input('agents'));
        return $this->response->item($residence, new ResidenceTransformer())->setStatusCode(201);
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
