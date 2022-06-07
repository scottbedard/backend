<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Toolbar extends Fluent
{
    /**
     * Toolbar items
     *
     * @var array
     */
    public array $items = [];

    /**
     * Searchable
     *
     * @var bool
     */
    public bool $searchable = false;

    /**
     * Construct
     *
     * @param array $items
     *
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }
}
