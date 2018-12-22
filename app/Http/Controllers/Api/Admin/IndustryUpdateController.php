<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateIndustryUpdateRequest;
use App\Http\Requests\Admin\UpdateIndustryUpdateRequest;
use App\Http\Response\Transformers\Admin\IndustryUpdateTransformer;
use App\Http\Controllers\Controller;
use App\IndustryUpdate;

class IndustryUpdateController extends Controller
{
    /**
     * 取得文章列表
     */
    public function index(IndustryUpdate $industryUpdate)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($industryUpdate);
        $industryUpdates = $eloquentBuilder->paginate();
        return $this->response->paginator($industryUpdates, new IndustryUpdateTransformer());
    }

    /**
     * 创建文章
     */
    public function store(CreateIndustryUpdateRequest $request, IndustryUpdate $industryUpdate)
    {
        $industryUpdate->fill($request->all());
        $industryUpdate->creator_id = $this->user()->id;
        $industryUpdate->save();
        return $this->response->item($industryUpdate, new IndustryUpdateTransformer());
    }

    /**
     * 修改文章
     */
    public function update(UpdateIndustryUpdateRequest $request, IndustryUpdate $industryUpdate)
    {
        $industryUpdate->fill($request->all());
        $industryUpdate->save();
        return $this->response->item($industryUpdate, new IndustryUpdateTransformer());
    }

    /**
     * 软删除文章
     */
    public function destroy(IndustryUpdate $industryUpdate)
    {
        $industryUpdate->delete();
        return $this->response->noContent();
    }
}
