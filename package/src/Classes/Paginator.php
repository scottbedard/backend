<?php

namespace Bedard\Backend\Classes;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Paginator
{
    public readonly array $items;

    public readonly int $currentPage;

    public readonly int $from;

    public readonly int $lastPage;

    public readonly int $perPage;

    public readonly int $to;

    public readonly int $total;

    /**
     * Static constructor
     *
     * @param  mixed  ...$args
     *
     * @return static
     */
    public static function for(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Create a paginator
     *
     * @param  EloquentBuilder|QueryBuilder  $query
     */
    public function __construct(EloquentBuilder|QueryBuilder $query)
    {
        $paginator = $query->paginate(20);

        $this->currentPage = $paginator->currentPage();

        $this->items = $paginator->items();

        $this->lastPage = $paginator->lastPage();

        $this->perPage = $paginator->perPage();

        $this->total = $paginator->total();

        $this->firstItem = $paginator->firstItem();

        $this->lastItem = $paginator->lastItem();
    }
}
