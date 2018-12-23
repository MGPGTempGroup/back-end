<?php

namespace App\Http\Controllers\Api\Admin;

use App\ServiceMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationStatisticsController extends Controller
{
    public function getCustomerCommentsCount(ServiceMessage $serviceMessage)
    {
        $count = $this->buildEloquentQueryThroughQs($serviceMessage)->count();
        return $this->response->array([
            'count' => $count
        ]);
    }
}
