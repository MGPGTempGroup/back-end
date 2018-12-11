<?php

namespace App\Http\Controllers\Api\Admin;

use App\HouseInspection;
use App\Http\Response\Transformers\Admin\HouseInspectionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HouseInspectionController extends Controller
{
    public function index(HouseInspection $houseInspection)
    {
        $inspectionsQueryBuilder = $this->buildEloquentQueryThroughQs($houseInspection);
        $inspections = $inspectionsQueryBuilder->paginate();
        return $this->response->paginator($inspections, new HouseInspectionTransformer());
    }
}
