<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Sort;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    public function test_parse_sort_none()
    {
        $sort = Sort::create('example.com', 'id');

        $this->assertEquals(0, $sort->direction);
        $this->assertNull($sort->column);
    }

    public function test_parse_sort_column_ascending()
    {
        $sort = Sort::create('example.com?sort=id,asc', 'id');

        $this->assertEquals(1, $sort->direction);
        $this->assertEquals('id', $sort->column);
    }

    public function test_parse_sort_column_descending()
    {
        $sort = Sort::create('example.com?sort=id,desc', 'id');

        $this->assertEquals(-1, $sort->direction);
        $this->assertEquals('id', $sort->column);
    }

    public function test_parse_sort_column_with_extra_data()
    {
        $sort = Sort::create('example.com?sort=id,asc&foo=bar', 'id');

        $this->assertEquals(1, $sort->direction);
        $this->assertEquals('id', $sort->column);
    }

    public function test_sort_direction_is_zero_when_column_does_not_match()
    {
        $sort = Sort::create('example.com?sort=id,asc', 'foo');

        $this->assertEquals(0, $sort->direction);
        $this->assertNull($sort->column);
    }
}
