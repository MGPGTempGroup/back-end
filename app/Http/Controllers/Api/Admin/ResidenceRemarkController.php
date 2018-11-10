<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateResidenceRemarkRequest;
use App\Http\Controllers\Controller;
use App\Http\Response\Transformers\Admin\ResidenceRemarkTransformer;
use App\ResidenceRemark;
use App\Residence;

class ResidenceRemarkController extends Controller
{
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
}
