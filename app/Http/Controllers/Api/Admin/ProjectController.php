<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProjectRequest;
use App\Http\Response\Transformers\Admin\ProjectTransformer;
use App\Project;

class ProjectController extends Controller
{
    /**
     * 创建项目
     */
    public function store(CreateProjectRequest $request, Project $project) {

        $project->fill($request->all());
        $project->creator_id = $this->user()->id;
        $project->save();

        // 同步该项目公司代理成员关联表数据
        if ($request->has('agents')) {
            $project->sync($request->input('agents'));
        }

        // 同步该项目产品类型关联数据
        if ($request->has('product_type')) {
            $project->sync($request->input('product_type'));
        }

        return $this->response->item($project, new ProjectTransformer())->setStatusCode(201);
    }
}
