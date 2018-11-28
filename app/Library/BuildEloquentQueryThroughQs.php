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
        'contains' => [],
        'between' => [],
        'basic_operators' => [
            'eq' => [], // 等于
            'neq' => [], // 不等于
            'lt' => [], // 小于
            'elt' => [], // 小于等于
            'gt' => [], // 大于
            'egt' => [] // 大于等于
        ]
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
            $this->parseBetweenThroughQs($key, $val);
            $this->parseBasicsOperatorThroughQs($key, $val);
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
     * Parse between through query string
     */
    private function parseBetweenThroughQs($key, $val)
    {
        if (($i = strpos($key, '_between')) !== false &&
            is_array($val) &&
            count($val) === 2) {
            $column = substr($key, 0, $i);
            $this->conditions['between'][$column] = $val;
        }
    }

    /**
     * Parse basic operator through query string
     */
    private function parseBasicsOperatorThroughQs($key, $val)
    {
        $keyNameArr = explode('_', $key);
        $operator = array_pop($keyNameArr);
        $availableOperators = array_keys($this->conditions['basic_operators']);
        if(in_array($operator, $availableOperators)) {
            $column = implode('_', $keyNameArr);
            $this->conditions['basic_operators'][$operator][$column] = $val;
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

        foreach ($this->conditions['orderby'] as $column => $sortRule) {
            $eloquentBuilder = $eloquentBuilder->orderBy($column, $sortRule);
        }

        foreach ($this->conditions['like'] as $column => $clauses) {
            $eloquentBuilder = $eloquentBuilder->where(function ($query) use ($clauses) {
                foreach ($clauses as $clause)
                    $query->orWhere(...$clause);
            });
        }

        foreach ($this->conditions['contains'] as $column => $arr) {
            $eloquentBuilder = $eloquentBuilder->whereIn($column, $arr);
        }

        foreach ($this->conditions['daterange'] as $column => $dataRangeArr) {
            $eloquentBuilder = $eloquentBuilder->where([
                [$column, '>', $dataRangeArr[0]],
                [$column, '<', $dataRangeArr[1]]
            ]);
        }

        foreach ($this->conditions['between'] as $column => $valueArr) {
            $eloquentBuilder = $eloquentBuilder->whereBetween($column, $valueArr);
        }

        $operatorMappingTable = [ 'eq' => '=', 'neq' => '<>', 'lt' => '<', 'elt' => '<=', 'gt' => '>', 'egt' => '>=' ];
        $whereClausesArr =  [];
        foreach ($this->conditions['basic_operators'] as $operator => $conditionalArr) {
            $dbRealOperator = $operatorMappingTable[$operator];
            foreach ($conditionalArr as $column => $val) {
                array_push($whereClausesArr, [
                    $column, $dbRealOperator, $val
                ]);
            }
        }
        $eloquentBuilder = $eloquentBuilder->where($whereClausesArr);

        return $eloquentBuilder;
    }

}
