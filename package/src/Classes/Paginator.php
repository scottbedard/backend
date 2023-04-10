<?php

namespace Bedard\Backend\Classes;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    /**
     * Normalize a length-aware paginator
     *
     * @return array
     */
    public static function for(EloquentBuilder|QueryBuilder $query)
    {
        $paginator = $query->paginate(20);

        return [
            'currentPage' => $paginator->currentPage(),
            'items' => $paginator->items(),
            'lastPage' => $paginator->lastPage(),
            'perPage' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];
    }
}