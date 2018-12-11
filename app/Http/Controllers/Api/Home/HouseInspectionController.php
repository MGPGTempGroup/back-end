<?php

namespace App\Http\Controllers\Api\Home;

use App\HouseInspection;
use App\Http\Requests\Home\CreateHouseInspectionRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Residence;
use App\Lease;

class HouseInspectionController extends Controller
{
    /**
     * 创建出售房屋预约
     */
    public function storeResidenceInspection(
        CreateHouseInspectionRequest $request,
        HouseInspection $houseInspection,
        Residence $residence)
    {
        $houseInspection->fill($request->all());
        $residence->inspections()->save(
            $houseInspection
        );
        return $this->response->created();
    }

    /**
     * 创建租赁房屋预约
     */
    public function storeLeaseInspection(
        CreateHouseInspectionRequest $request,
        HouseInspection $houseInspection,
        Lease $lease)
    {
        $houseInspection->fill($request->all());
        $lease->inspections()->save(
            $houseInspection
        );
        return $this->response->created();
    }
}
