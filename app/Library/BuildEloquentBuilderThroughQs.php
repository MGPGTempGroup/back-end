<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait BuildEloquentBuilderThroughQs
{

    // Request实例
    public $request;

    // 通过解析查询字符串后的条件列表
    public $conditions = [
        'orderby' => [],
        'pagesize' => 15
    ];

    /**
     * BuildEloquentBuilderThroughQs constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 返回通过查询字符串构建查询条件之后的Eloquent Builder
     *
     * @param $model
     * @return $this
     */
    public function buildEloquentBuilderThroughQs($model)
    {
        return $this->parseQueryString()->build($model);
    }

    /**
     * 解析查询字符串，找出指定的查询条件
     *
     * @return $this
     */
    protected function parseQueryString()
    {
        $queryString = array_change_key_case($this->request->query());

        foreach ($queryString as $condition => $val) {

            if (!$val) continue;

            // 解析排序条件参数
            if (stripos($condition, 'orderby') === 0) {
                $column = explode('orderby', $condition)[1];
                $this->conditions['orderby'][$column] = $val;
            }
            // 解析分页大小参数
            if (strcmp($condition, 'pagesize') === 0) {
                $this->conditions['pagesize'] = (int) $val;
            }
        }

        return $this;
    }

    /**
     * 通过解析查询字符串得到的条件列表构建QueryBuilder
     *
     * @param $model
     * @return $this
     */
    protected function build($model)
    {

        // 判断model参数是一个模型还是一个关联关系实例，设置相应模型默认分页大小（perPage）
        if ($model instanceof Model) {

            $eloquentBuilder = $model->setPerPage($this->conditions['pagesize']);

        } else if ($model instanceof Relation) {

            // 如果$model是一个关联关系对象，那么找到关联模型实例再设置perPage
            $eloquentBuilder = $model->getRelated()->setPerPage($this->conditions['pagesize']);

        }

        // 依次添加排序条件
        foreach ($this->conditions['orderby'] as $column => $sortRule) {
            $eloquentBuilder = $eloquentBuilder->orderBy($column, $sortRule);
        }

        return $eloquentBuilder;
    }

}
