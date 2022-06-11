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
     * Data
     *
     * @var array
     */
    protected $data = [
        'resource' => null,
        'rows' => [],
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
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        $this->to = function ($row) {
            return route('backend.resources.update', [
                'id' => $this->data['resource']::$id,
                'modelId' => $row->{$this->data['resource']::$modelKey},
            ]);
        };
    }

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
