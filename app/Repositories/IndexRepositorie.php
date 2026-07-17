<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * class IndexRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class IndexRepositorie
{
    public Model $model;
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Parse query parameters for formatting, pagination, sorting, and filtering.
     *
     * @param array $params
     * @return array
     */
    public function parseQueryParams(array $params)
    {
        return [
            'first' => $params['first'] ?? false,
            'rows' => $params['rows'] ?? false,
            'orderBy' => $params['orderBy'] ?? 'updated_at',
            'ascending' => $params['ascending'] ?? 0,
            'filters' => $filters = json_decode($params['filters'] ?? '{}', true),
            'columns' => isset($params['columns']) ? json_decode($params['columns']) : array_keys($filters),
        ];
    }

    /**
     * Build the query for the model applying filters, sorting, and relations.
     *
     * @param mixed $first
     * @param mixed $rows
     * @param string $orderBy
     * @param mixed $ascending
     * @param array $filters
     * @param array|null $columns
     * @param mixed|null $baseQuery
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getModelQuery($first, $rows, $orderBy, $ascending, $filters, $columns = null, $baseQuery = null)
    {
        $query = $baseQuery ?? $this->model::query();
        $query->selectRaw($this->model->getTable() . '.*');

        foreach ($filters as $column => $filter) {
            if (gettype($filter['value']) == 'string') {
                $filter['value'] = trim($filter['value'], '%');
            }
            if ($filter['value'] !== null && $filter['value'] !== '') {
                $query->filterByColumn($column, $filter['value'], $filter['matchMode'] ?? null);
            }
        }

        $order = $ascending === '1' ? 'ASC' : 'DESC';
        $query->orderByColumn($orderBy, $order);

        if (! empty($columns)) {
            if (method_exists($this->model, 'scopeWithRelationships')) {
                $query->withRelationships($columns);
            }
        }

        return $query;
    }

    /**
     * Display a listing of the resource with pagination, count, filters and column selection.
     *
     * @param mixed $first
     * @param mixed $rows
     * @param string $orderBy
     * @param mixed $ascending
     * @param array $filters
     * @param array $columns
     * @param mixed|null $baseQuery
     * @return array
     */
    public function index($first, $rows, $orderBy, $ascending, $filters, $columns, $baseQuery = null)
    {
        array_push($columns, 'id');

        $query = $this->getModelQuery($first, $rows, $orderBy, $ascending, $filters, null, $baseQuery);
        if (method_exists($this->model, 'scopeWithAliasScopes')) {
            $query->withAliasScopes($columns);
        }

        $count = DB::query()->from($query)->count();

        if ($rows !== false && $first !== false) {
            $query->offset($first)->limit($rows);
        }

        $data = $query->get();

        $data = $data->map(function ($_data) use ($columns) {
            return $_data->only($columns);
        });

        return [
            'data' => $data,
            'count' => $count,
        ];
    }
}