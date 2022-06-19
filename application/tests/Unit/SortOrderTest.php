<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Exceptions\InvalidSortOrderException;
use PHPUnit\Framework\TestCase;

class SortOrderTest extends TestCase
{
    public function test_parse_column()
    {
        $order = SortOrder::from('foo,asc');

        $this->assertEquals('foo', $order->property);
    }

    public function test_parse_ascending_order()
    {
        $order = SortOrder::from('foo,asc');

        $this->assertEquals(1, $order->direction);
    }

    public function test_parse_descending_order()
    {
        $order = SortOrder::from('foo,desc');

        $this->assertEquals(-1, $order->direction);
    }

    public function test_malformed_strings_throw_exception()
    {
        $this->expectException(InvalidSortOrderException::class);

        SortOrder::from('malformed string');
    }

    public function test_sort_order_to_string_ascending()
    {
        $order = SortOrder::from('foo,asc');

        $this->assertEquals('foo,asc', (string) $order);

        $this->assertEquals('foo,asc', $order->toString());
    }

    public function test_sort_order_to_string_descending()
    {
        $order = SortOrder::from('foo,desc');

        $this->assertEquals('foo,desc', (string) $order);

        $this->assertEquals('foo,desc', $order->toString());
    }
}
