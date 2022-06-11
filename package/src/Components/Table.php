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
        'pageSize' => 20,
        'selectable' => false,
        'to' => null,
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
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('backend::renderables.table', [
            'columns' => $this->columns,
            'data' => $this->data,
            'pageSize' => $this->pageSize,
            'selectable' => $this->selectable,
            'to' => $this->to,
        ]);
    }
}
