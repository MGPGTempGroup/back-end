<?php

namespace App\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait BuildEloquentQueryThroughQs
{

    // Conditional list obtained by parsing query string
    private $conditions = [
        'orderby' => [],
        'like' => [],
        'daterange' => [],
        'pagesize' => 15,
        'contains' => []
    ];

    /**
     * Return the Eloquent Builder after constructing the query condition through the query string
     *
     * @param $model
     * @return $this
     */
    public function buildEloquentQueryThroughQs($model, $queryString = null)
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
            $this->parseLikeQueryThroughQs($key, $val);
            $this->parsePageSizeThroughQs($key, $val);
            $this->parseDateRangeThroughQs($key, $val);
            $this->parseContainsThroughQs($key, $val);
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
            $column = explode('orderby_', $key, 2)[1];
            $this->conditions['orderby'][$column] = $val;
        }
    }

    /**
     * Parse like clauses through query string
     *
     * @param $key
     * @param $val
     */
    private function parseLikeQueryThroughQs($key, $val)
    {
        if (($i = strpos($key, '_like')) !== false) {
            $column = substr($key, 0, $i);
            $clauses = array_map(function ($item) use ($column) {
                return [$column, 'like', '%' . $item . '%'];
            }, $val);
            $this->conditions['like'][$column] = $clauses;
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
     * Parse date range through query string
     */
    private function parseDateRangeThroughQs($key, $val)
    {
        if (strpos($key, 'daterange_') === 0 && count($val) === 2) {
            $column = explode('_', $key, 2)[1];
            $this->conditions['daterange'][$column] = [$val[0], $val[1]];
        }
    }

    /**
     * Parse contains through query string
     */
    private function parseContainsThroughQs($key, $val)
    {
        if (strpos($key, 'contains_') === 0 && is_array($val)) {
            $column = explode('contains_', $key, 2)[1];
            $this->conditions['contains'][$column] = $val;
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

        // 添加like条件
        foreach ($this->conditions['like'] as $column => $clauses) {
            $eloquentBuilder = $eloquentBuilder->where(function ($query) use ($clauses) {
                foreach ($clauses as $clause)
                    $query->orWhere(...$clause);
            });
        }

        // 添加in条件
        foreach ($this->conditions['contains'] as $column => $arr) {
            $eloquentBuilder = $eloquentBuilder->whereIn($column, $arr);
        }

        // 添加dateRange条件
        foreach ($this->conditions['daterange'] as $column => $dataRangeArr) {
            $eloquentBuilder = $eloquentBuilder->where([
                [$column, '>', $dataRangeArr[0]],
                [$column, '<', $dataRangeArr[1]]
            ]);
        }

        return $eloquentBuilder;
    }

}
