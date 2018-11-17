<?php

namespace App\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait BuildEloquentBuilderThroughQs
{

    // Conditional list obtained by parsing query string
    private $conditions = [
        'orderby' => [],
        'where' => [],
        'pagesize' => 15
    ];

    /**
     * Return the Eloquent Builder after constructing the query condition through the query string
     *
     * @param $model
     * @return $this
     */
    public function buildEloquentBuilderThroughQs($model, $queryString = null)
    {
        if (is_null($queryString)) {
            $queryString = app('request')->query();
        }
        return $this->parser($queryString)->build($model);
    }

    /**
     * Parsing query strings
     *
     * @return $this
     */
    private function parser($queryString)
    {
        $queryString = array_change_key_case($queryString);

        foreach ($queryString as $key => $val) {
            if (! $val) continue;
            $this->parseOrderClausesThroughQs($key, $val);
            $this->parseWhereClausesThroughQs($key, $val);
            $this->parsePageSizeThroughQs($key, $val);
        }

        return $this;
    }

    /**
     * Parse order clauses through query string
     *
     * @param $key
     * @param $val
     */
    private function parseOrderClausesThroughQs($key, $val)
    {
        if (strpos($key, 'orderby_') === 0) {
            $column = substr($key, 8);
            $this->conditions['orderby'][$column] = $val;
        }
    }

    /**
     * Parse like clauses through query string
     *
     * @param $key
     * @param $val
     */
    private function parseWhereClausesThroughQs($key, $val)
    {
        if (($i = strpos($key, '_like')) !== false) {
            $column = substr($key, 0, $i);
            if (is_array($val)) {
                $clauses = array_map(function ($item) use ($column) {
                    return [$column, 'like', $item];
                }, $val);
                array_push($this->conditions['where'], ...$clauses);
            } else {
                array_push($this->conditions['where'], [$column, 'like', $val]);
            }
        }
    }

    /**
     * Parse pageSize through query string
     *
     * @param $key
     * @param $val
     */
    private function parsePageSizeThroughQs($key, $val)
    {
        if (strcmp($key, 'pagesize') === 0) {
            $this->conditions['pagesize'] = (int) $val;
        }
    }

    /**
     * Building queryBuilder through conditions
     *
     * @param $model
     * @return $this
     */
    private function build($model)
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

        // 添加where条件
        $eloquentBuilder = $eloquentBuilder->where($this->conditions['where']);

        return $eloquentBuilder;
    }

}
