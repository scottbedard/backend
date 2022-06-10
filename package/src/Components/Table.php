<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;

class Table extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'columns' => [],
    ];

    /**
     * Providable
     *
     * @var array
     */
    protected $providable = [
        'columns',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('backend::renderables.table');
    }
}
