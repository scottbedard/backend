<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;

class Table extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'columns' => [],
        'pageSize' => 20,
        'selectable' => false,
        'toolbar' => [],
    ];
}
