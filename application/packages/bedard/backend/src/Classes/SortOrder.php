<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Exceptions\InvalidSortOrderException;

class SortOrder
{
    /**
     * Sort direction
     *
     * -1 = descending
     *  0 = none
     *  1 = ascending
     *
     * @var int
     */
    public int $direction = 0;

    /**
     * Property
     *
     * @var string
     */
    public string $property = '';

    /**
     * Constructor
     *
     * @param string $order
     *
     * @return void
     */
    public function __construct(string $order)
    {
        $this->apply($order);
    }

    /**
     * Apply an order
     *
     * @param string $order
     *
     * @return void
     */
    public function apply(string $order): void
    {
        $match = preg_match('/^([a-zA-Z0-9_-]+),([aA][sS][cC]|[dD][eE][sS][cC])$/', trim($order), $matches);

        if (!$match) {
            throw new InvalidSortOrderException($order);
        }

        $this->property = $matches[1];
        
        if (strtolower($matches[2]) === 'asc') {
            $this->direction = 1;
        } elseif (strtolower($matches[2] === 'desc')) {
            $this->direction = -1;
        }
    }

    /**
     * Create sort order from string.
     *
     * @param string $order
     *
     * @return \Bedard\Backend\Classes\SortOrder
     */
    public static function from(string $order)
    {
        return new self($order);
    }
}