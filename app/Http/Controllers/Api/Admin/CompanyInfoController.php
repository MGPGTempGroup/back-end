<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\CompanyInfoTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateCompanyInfoRequest;
use App\Http\Controllers\Controller;

use App\CompanyInfo;

class CompanyInfoController extends Controller
{

    /**
     * 展示公司信息数据
     */
    public function show(CompanyInfo $companyInfo)
    {
        return $this->response->item($companyInfo->getLatest(), new CompanyInfoTransformer());
    }

    /**
     * 更新公司信息数据
     *
     * 此处更新并非直接更新原有公司数据
     * 将会查询出更新之前最新的数据 和 请求中要修改的字段 进行合并 然后创建一条新的数据
     * （为了保留历史的更改）
     */
    public function update(UpdateCompanyInfoRequest $request, CompanyInfo $companyInfo)
    {
        $info = $companyInfo->getLatest()->toArray();
        $companyInfo->fill(
            array_merge($info, $request->all())
        );
        $companyInfo->save();
        return $this->response->item($companyInfo, new CompanyInfoTransformer());
    }
}
