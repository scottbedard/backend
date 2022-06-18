<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Exceptions\InvalidAttributeException;
use Bedard\Backend\Exceptions\InvalidSortOrderException;
use Bedard\Backend\Util;

class Column extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'align' => 'left',
        'header' => '',
        'id' => '',
        'sortable' => false,
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'date' => DateColumn::class,
        'icon' => IconColumn::class,
    ];

    /**
     * Render default column.
     *
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function column(array $data = [])
    {
        return view('backend::partials.table.column', array_merge($this->attributes, $data));
    }

    /**
     * Get href for column header
     *
     * @return string
     */
    public function href()
    {
        if (!$this->sortable) {
            return null;
        }

        $req = request();

        $order = data_get($this->data, 'order', null);

        if ($order !== null) {
            if ($order->property !== $this->id || $order->direction === -1) {
                return route('backend.resources.show', array_merge($req->query(), [
                    'id' => $req->id,
                    'order' => "{$this->id},asc",
                    'page' => null,
                ]));
            } elseif ($order->direction === 1) {
                return route('backend.resources.show', array_merge($req->query(), [
                    'id' => $req->id,
                    'order' => "{$this->id},desc",
                    'page' => null,
                ]));
            }
        }

        return '#';
    }

    /**
     * Initialize
     *
     * @param string $id
     *
     * @return void
     */
    public function init($id = '')
    {
        $this->attributes['id'] = $id;
    }

    /**
     * Output
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return fn ($row) => $row->{$this->id};
    }

    /**
     * Sort order
     *
     * @return int
     */
    public function sortOrder(): int
    {
        $order = data_get($this->data, 'order', null);
        
        return ($order && $order->property === $this->id) ? $order->direction : 0;
    }

    /**
     * Set align
     *
     * @param string $align
     *
     * @throws \Bedard\Backend\Exceptions\InvalidAttributeException
     *
     * @return void
     */
    public function setAlignAttribute(string $value)
    {
        $alignments = ['left', 'right', 'center'];

        if (!in_array($value, $alignments)) {
            $suggestion = Util::suggest($value, $alignments);

            throw new InvalidAttributeException("Unknown toolbar alignment \"{$value}\", did you mean \"{$suggestion}\"?");
        }

        $this->attributes['align'] = $value;
    }
}
