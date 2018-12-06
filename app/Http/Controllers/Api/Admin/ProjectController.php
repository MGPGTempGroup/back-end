<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Http\Response\Transformers\Admin\ProjectTransformer;
use App\Project;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * 展示项目列表
     */
    public function index(Request $request, Project $project)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($project);
        $projects = $eloquentBuilder
            ->when($request->query('agents'), function ($query, $agentsId) {
                $projectsId = DB::table('project_agent')
                    ->select('project_id')
                    ->whereIn('member_id', $agentsId)
                    ->pluck('project_id');
                return $query->whereIn('id', $projectsId);
            })
            ->when($request->query('product_types'), function ($query, $productTypesId) {
                $projectsId = DB::table('project_product_type')
                    ->select('project_id')
                    ->whereIn('product_type_id', $productTypesId)
                    ->pluck('project_id');
                return $query->whereIn('id', $projectsId);
            })
            ->paginate();

        return $this->response->paginator($projects, new ProjectTransformer());
    }

    /**
     * 创建项目
     */
    public function store(CreateProjectRequest $request, Project $project) {

        $project->fill($request->all());
        $project->setAttribute('creator_id', $this->user()->id);
        $project->save();

        // 同步该项目公司代理成员关联表数据
        if ($request->has('agents')) {
            $project->agents()->sync($request->input('agents'));
        }

        // 同步该项目产品类型关联数据
        if ($request->has('product_type')) {
            $project->productTypes()->sync($request->input('product_type'));
        }

        return $this->response->item($project, new ProjectTransformer())->setStatusCode(201);
    }

    /**
     * 修改项目
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->fill($request->all());
        $project->save();

        // 同步该项目公司代理成员关联表数据
        if ($request->has('agents')) {
            $project->agents()->sync($request->input('agents'));
        }

        // 同步该项目产品类型关联数据
        if ($request->has('product_type')) {
            $project->productTypes()->sync($request->input('product_type'));
        }

        return $this->response->item($project, new ProjectTransformer());
    }

    /**
     * 软删除某项目数据
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return $this->response->noContent();
    }
}
