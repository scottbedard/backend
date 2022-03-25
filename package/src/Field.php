<?php

namespace Bedard\Backend;

class Field
{
    /**
     * Column
     *
     * @var string
     */
    protected string $column;

    /**
     * Label
     *
     * @var string
     */
    protected string $label;

    /**
     * Type
     *
     * @var string
     */
    protected string $type;

    /**
     * Field construction
     *
     * @param string $type
     * @param array $arguments
     *
     * @return \Bedard\Backend\Field
     */
    public static function __callStatic(string $type, array $arguments)
    {
        return new self($type, 'temp');
    }

    /**
     * Construct
     *
     * @return void
     */
    public function __construct(string $type, string $column)
    {
        $this->column = $column;

        $this->type = $type;
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