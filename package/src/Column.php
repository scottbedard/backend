<?php

namespace Bedard\Backend;

use Illuminate\Support\Arr;

class Column
{
    /**
     * Column
     *
     * @var string
     */
    public string $column;

    /**
     * Header
     *
     * @var string
     */
    public string $header;

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
     * Render column header
     */
    public function renderHeader()
    {
        return view('backend::columns.default-header', [
            'header' => $this->header,
        ]);
    }
}