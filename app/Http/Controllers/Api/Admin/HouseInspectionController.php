<?php

namespace App\Http\Controllers\Api\Admin;

use App\HouseInspection;
use App\Http\Response\Transformers\Admin\HouseInspectionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HouseInspectionController extends Controller
{
    /**
     * 预约检查列表数据
     */
    public function index(Request $request, HouseInspection $houseInspection)
    {
        $inspectionsQueryBuilder = $this->buildEloquentQueryThroughQs($houseInspection);
        $inspections = $inspectionsQueryBuilder
            ->when($request->query('type'), function ($query, $type) {
                return $query->where('house_type', $type);
            })
            ->paginate();
        return $this->response->paginator($inspections, new HouseInspectionTransformer());
    }

    /**
     * 跟进
     */
    public function followUp(HouseInspection $houseInspection)
    {
        if (! $houseInspection->followUp) {
            $houseInspection->follow_up = $this->user()->id;
            $houseInspection->save();
            return $this->response->created();
        }
        return $this->response->errorForbidden();
    }

    /**
     * 软删除
     */
    public function destroy(HouseInspection $houseInspection)
    {
        $houseInspection->delete();
        return $this->response->noContent();
    }
}
