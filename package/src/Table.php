<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Table extends Fluent
{
    /**
     * Columns.
     * 
     * @param array
     */
    public array $columns = [];

    /**
     * Default page size.
     *
     * @var int
     */
    public int $pageSize = 20;

    /**
     * Selectable.
     *
     * @var bool
     */
    public bool $selectable = false;
}
