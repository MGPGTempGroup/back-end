<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateLeaseRequest;
use App\Http\Requests\Admin\UpdateLeaseRequest;
use App\Http\Response\Transformers\Admin\LeaseTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lease;

class LeaseController extends Controller
{

    /**
     * 展示租赁房屋列表
     */
    public function index(Request $request, Lease $lease)
    {
        $leases = $this->buildEloquentQueryThroughQs($lease)->paginate();
        return $this->response->paginator($leases, new LeaseTransformer());
    }

    /**
     * 展示租赁房屋数据详情
     */
    public function show(Lease $lease)
    {
        return $this->response->item($lease, new LeaseTransformer());
    }

    /**
     * 创建租赁房屋
     */
    public function store(CreateLeaseRequest $request, Lease $lease)
    {
        $lease->fill($request->all());
        if(($address = $request->input('address')) && count($address) === 3) {
            $lease->state_code = $address[1]['code'];
            $lease->city_code = $address[2]['code'];
        }
        $lease->save();
        $lease->propertyType()->attach($request->property_type);
        return $this->response->item($lease, new LeaseTransformer());
    }

    /**
     * 修改房屋数据
     */
    public function update(UpdateLeaseRequest $request, Lease $lease)
    {
        $lease->fill($request->all());
        $lease->save();
        if ($request->property_type_id) {
            $lease->propertyType()->sync($request->property_type_id);
        }
        return $this->response->item($lease, new LeaseTransformer());
    }

    /**
     * 软删除租赁房屋数据
     */
    public function destroy(Lease $lease)
    {
        $lease->delete();
        return $this->response->noContent();
    }
}
