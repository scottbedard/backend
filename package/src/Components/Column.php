<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;
use Bedard\Backend\Components\DateColumn;
use Bedard\Backend\Exceptions\InvalidAttributeException;
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
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'date' => DateColumn::class,
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
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return fn ($row) => $row->{$this->id};
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
