<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Exceptions\InvalidAttributeException;
use Illuminate\Support\Arr;
class Table extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'columns' => [],
        'defaultOrder' => null,
        'pageSize' => 15,
        'selectable' => false,
        'to' => null,
        'toolbar' => [],
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
        $paginator = data_get($this->data, 'rows');

        $id = data_get($this->data, 'resource')::$id;

        $query = Arr::except(request()->query(), 'page');

        $firstPageHref = route('backend.resources.show', array_merge($query, [
            'id' => $id,
        ]));

        $prevPageHref = route('backend.resources.show', array_merge($query, [
            'id' => $id,
            'page' => max(1, $paginator->currentPage() - 1),
        ]));

        $nextPageHref = route('backend.resources.show', array_merge($query, [
            'id' => $id,
            'page' => max(1, $paginator->currentPage() + 1),
        ]));

        $lastPageHref = route('backend.resources.show', array_merge($query, [
            'id' => $id,
            'page' => max(1, $paginator->lastPage() - 1),
        ]));

        return view('backend::renderables.table', [
            'columns' => $this->columns,
            'currentPage' => $paginator->currentPage(),
            'data' => $this->data,
            'firstPageHref' => $firstPageHref,
            'lastPage' => $paginator->lastPage(),
            'lastPageHref' => $lastPageHref,
            'nextPageHref' => $nextPageHref,
            'pageSize' => $this->pageSize,
            'prevPageHref' => $prevPageHref,
            'selectable' => $this->selectable,
            'to' => $this->to,
            'toolbar' => $this->toolbar,
        ]);
    }
}
