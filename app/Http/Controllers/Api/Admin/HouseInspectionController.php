<?php

namespace App\Http\Controllers\Api\Admin;

use App\HouseInspection;
use App\Http\Response\Transformers\Admin\HouseInspectionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HouseInspectionController extends Controller
{
    public function index(Request $request, HouseInspection $houseInspection)
    {
        $inspectionsQueryBuilder = $this->buildEloquentQueryThroughQs($houseInspection);
        $inspections = $inspectionsQueryBuilder
            ->when($request->query('type'), function ($query, $type) {
                return $query->houseType($type);
            })
            ->paginate();
        return $this->response->paginator($inspections, new HouseInspectionTransformer());
    }
}
