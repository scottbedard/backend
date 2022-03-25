<?php

namespace Bedard\Backend;

use Illuminate\Support\Arr;

class Field
{
    /**
     * Column
     *
     * @var string
     */
    public string $column;

    /**
     * Label
     *
     * @var string
     */
    public string $label;

    /**
     * Field construction
     *
     * @param string $field
     * @param array $args
     *
     * @return \Bedard\Backend\Field
     */
    public static function __callStatic(string $field, array $args = [])
    {
        $common = [
            'number' => \Bedard\Backend\Fields\NumberField::class
        ];

        if (Arr::exists($common, $field)) {
            return new ($common[$field])(...$args);
        }
    }

    /**
     * Static constructor for custom field types
     *
     * @param string $column
     *
     * @return \Bedard\Backend\Field
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
     * Label
     *
     * @param string $label
     *
     * @return \Bedard\Backend\Field
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }
}