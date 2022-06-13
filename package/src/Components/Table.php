<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Block;

class Table extends Block
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
     * Data
     *
     * @var array
     */
    protected $data = [
        'resource' => null,
        'rows' => [],
    ];

    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        $this->to = fn ($row) => route('backend.resources.edit', [
            'id' => $this->data['resource']::$id,
            'modelId' => $row->{$this->data['resource']::$modelKey},
        ]);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
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
