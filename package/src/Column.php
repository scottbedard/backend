<?php

namespace Bedard\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Column
{
    /**
     * Align
     *
     * @var string
     */
    public string $align = 'left';

    /**
     * Column
     *
     * @var string
     */
    public string $column = '';

    /**
     * Header
     *
     * @var string
     */
    public string $header = '';

    /**
     * Field construction
     *
     * @param string $column
     * @param array $args
     *
     * @return \Bedard\Backend\Column
     */
    public static function __callStatic(string $column, array $args = [])
    {
        $common = [
            'number' => \Bedard\Backend\Columns\NumberColumn::class,
            'text' => \Bedard\Backend\Columns\TextColumn::class,
        ];

        if (Arr::exists($common, $column)) {
            return new ($common[$column])(...$args);
        }

        return new static($column);
    }

    /**
     * Static constructor for custom column types
     *
     * @param string $column
     *
     * @return \Bedard\Backend\Column
     */
    public static function make(string $column)
    {
        return new static($column);
    }

    /**
     * Construct
     *
     * @return void
     */
    public function __construct(string $column)
    {
        $this->column = $column;
    }

    /**
     * Align
     *
     * @param string $header
     *
     * @return \Bedard\Backend\Column
     */
    public function align(string $align)
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Header
     *
     * @param string $header
     *
     * @return \Bedard\Backend\Column
     */
    public function header(string $header)
    {
        $this->header = $header;

        return $this;
    }
    
    /**
     * Render column
     */
    public function render(Model $model)
    {
        return $model->{$this->column};
    }

    /**
     * Render column header
     */
    public function renderHeader()
    {
        return view('backend::columns.default-header', [
            'align' => $this->align,
            'header' => $this->header ?: $this->column,
        ]);
    }
}