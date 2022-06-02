<?php

namespace Tests\Feature\Columns;

use App\Models\User;
use Bedard\Backend\Column;
use Bedard\Backend\Exceptions\InvalidColumnAlignmentException;
use Tests\TestCase;

class ColumnTest extends TestCase
{
    public function test_rendering_a_generic_column()
    {
        $user = User::factory()->create();

        $column = Column::make('id');

        $this->assertEquals($user->id, $column->render($user));
    }

    public function test_rendering_a_generic_header()
    {
        $column = Column::make('id');

        $this->assertEquals('left', $column->align);
        $this->assertEquals('', $column->header);
        $this->assertEquals('id', $column->renderHeader());
    }

    public function test_rendering_a_custom_header()
    {
        $header = Column::make('id')->header('foo')->renderHeader();

        $this->assertEquals('foo', $header);
    }

    public function test_setting_a_custom_alignment()
    {
        $column = Column::make('id')->align('right');

        $this->assertEquals('right', $column->align);
    }

    public function test_setting_an_invalid_alignment()
    {
        $this->expectException(InvalidColumnAlignmentException::class);

        Column::make('id')->align('foobar');
    }

    public function test_constructing_common_column_types()
    {
        $types = [
            'carbon' => \Bedard\Backend\Columns\CarbonColumn::class,
            'number' => \Bedard\Backend\Columns\NumberColumn::class,
            'text' => \Bedard\Backend\Columns\TextColumn::class,
        ];

        $this->assertEqualsCanonicalizing($types, Column::$constructors);
        
        foreach ($types as $name => $class) {
            $this->assertInstanceOf($class, Column::{$name}('id'));
        }
    }

    public function test_setting_custom_column_properties()
    {
        $column = new class extends Column
        {
            public $foo; // <- properties without methods are inferred using __call()

            public $bar;

            public function bar()
            {
                $this->bar = 'bar';

                return $this;
            }
        };
        
        $column->foo('foo')->bar();
        
        $this->assertEquals('foo', $column->foo);
        $this->assertEquals('bar', $column->bar);
    }
}
