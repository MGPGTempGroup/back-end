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
     * 创建出售房屋数据
     */
    public function store(CreateResidenceRequest $request, Residence $residence)
    {
        $residence->fill($request->all());
        $residence->save();
        return $this->response->item($residence, new ResidenceTransformer());
    }

    /**
     * 修改出售房屋数据
     */
    public function update(UpdateResidenceRequest $request, Residence $residence)
    {
        $residence->fill($request->all());
        $residence->save();
        return $this->response->item($residence, new ResidenceTransformer());
    }

}
