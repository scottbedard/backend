<?php

namespace Tests\Unit;

use Bedard\Backend\Column;
use Bedard\Backend\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    public function test_instantiating_a_table()
    {
        $foo = Column::make('foo');

        $table = Table::columns([$foo])
            ->pageSize(123)
            ->selectable();

        $this->assertInstanceOf(Table::class, $table);

        $this->assertEquals([$foo], $table->columns);

        $this->assertEquals(123, $table->pageSize);

        $this->assertTrue($table->selectable);
    }
}
