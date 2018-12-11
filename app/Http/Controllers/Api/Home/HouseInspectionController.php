<?php

namespace App\Http\Controllers\Api\Home;

use App\HouseInspection;
use App\Http\Requests\Home\CreateHouseInspectionRequest;
use App\Http\Controllers\Controller;
use App\Residence;
use App\Lease;
use App\AdminUser;
use App\Notifications\HouseInspection as HouseInspectionNotifycation;
use Notification;

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
        $this->notifyAllAdminUsers($houseInspection);
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
        $this->notifyAllAdminUsers($houseInspection);
        return $this->response->created();
    }

    /**
     * 给所有AdminUsers发送房屋预约检查通知
     */
    protected function notifyAllAdminUsers(HouseInspection $houseInspection)
    {
        try {
            $users = AdminUser::get();
            Notification::send(
                $users,
                new HouseInspectionNotifycation($houseInspection)
            );
        } catch (\Exception $e) {
            // ...
        }
    }

}
