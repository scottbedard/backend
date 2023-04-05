<?php

namespace Bedard\Backend\Classes;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    protected LengthAwarePaginator $paginator;

    /**
     * Create a paginator
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Normalize a length-aware paginator
     *
     * @return array
     */
    public function data()
    {
        return [
            'currentPage' => $this->paginator->currentPage(),
            'items' => $this->paginator->items(),
            'lastPage' => $this->paginator->lastPage(),
            'perPage' => $this->paginator->perPage(),
            'total' => $this->paginator->total(),
        ];
    }
}