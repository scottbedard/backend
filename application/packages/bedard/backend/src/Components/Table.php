<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Exceptions\InvalidAttributeException;
class Table extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'defaultOrder' => null,
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
     * Set default order
     *
     * @param \Bedard\Backend\Classes\SortOrder|string $order
     * @param string $direction
     *
     * @return void
     */
    public function setDefaultOrderAttribute($order, $direction = null)
    {
        if (is_string($order) && $direction === null) {
            $this->attributes['defaultOrder'] = SortOrder::from("{$order},asc");

            return;
        }
        
        if (is_string($order) && is_string($direction)) {
            $this->attributes['defaultOrder'] = SortOrder::from("{$order},{$direction}");

            return;
        }
        
        if ($order instanceof SortOrder) {
            $this->attributes['defaultOrder'] = $order;

            return;
        }

        throw new InvalidAttributeException('Invalid sort order');
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
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
