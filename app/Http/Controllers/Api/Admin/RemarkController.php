<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateRemarkRequest;
use App\Http\Requests\Admin\UpdateRemarkRequest;
use App\Http\Response\Transformers\Admin\RemarkTransformer;
use App\Remark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemarkController extends Controller
{
    public function index(Request $request, Remark $remark)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($remark);
        $eloquentBuilder = $eloquentBuilder
            ->where('come_from_type', $request->query('come_from_type'))
            ->where('come_from_id', $request->query('come_from_id'))
            ->orderBy('created_at', 'DESC');
        $remarks = $eloquentBuilder->paginate();
        return $this->response->paginator($remarks, new RemarkTransformer());
    }

    public function store(CreateRemarkRequest $request, Remark $remark)
    {
        $remark->fill($request->all());
        $remark->creator_id = $this->user()->id;
        $remark->save();
        return $this->response->item($remark, new RemarkTransformer());
    }

    public function update(UpdateRemarkRequest $request, Remark $remark)
    {
        $remark->content = $request->input('content');
        $remark->save();
        return $this->response->item($remark, new RemarkTransformer());
    }

    public function destroy(Remark $remark)
    {
        $remark->delete();
        return $this->response->noContent();
    }
}
