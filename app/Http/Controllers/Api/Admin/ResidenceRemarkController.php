<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateResidenceRemarkRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateResidenceRemarkRequest;
use App\Http\Response\Transformers\Admin\ResidenceRemarkTransformer;
use App\ResidenceRemark;
use App\Residence;

class ResidenceRemarkController extends Controller
{

    /**
     * 展示出售房屋备注数据列表
     */
    public function index(Residence $residence)
    {
        $residenceRemarkRelation = $residence->remarks();
        $remarks = $this->buildEloquentQueryThroughQs($residenceRemarkRelation)->paginate();

        return $this->response->paginator($remarks, new ResidenceRemarkTransformer());
    }

    /**
     * 创建出售房屋备注
     */
    public function store(CreateResidenceRemarkRequest $request, ResidenceRemark $residenceRemark, $residence)
    {
        if (! Residence::where('id', $residence)->exists()) $this->response->noContent();

        $residenceRemark->fill($request->all());
        $residenceRemark->residence_id = $residence;
        $residenceRemark->save();

        return $this->response->item($residenceRemark, new ResidenceRemarkTransformer());
    }

    /**
     * 修改出售房屋备注
     */
    public function update(UpdateResidenceRemarkRequest $request, ResidenceRemark $residenceRemark)
    {
        $residenceRemark->content = $request->input('content');
        $residenceRemark->save();

        return $this->response->item($residenceRemark, new ResidenceRemarkTransformer());
    }

    /**
     * 软删除出售房屋备注数据
     */
    public function destroy(ResidenceRemark $residenceRemark)
    {
        $residenceRemark->delete();
        return $this->response->noContent();
    }
}
