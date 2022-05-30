<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Exceptions\FluentException;
use PHPUnit\Framework\TestCase;

class Foo extends Fluent
{
    public static array $constructors = [
        'bar' => Bar::class,
    ];

    public $arg;

    public function __construct($arg)
    {
        $this->arg = $arg;
    }
}

class Bar extends Fluent
{
    public $thing;

    public function __construct($thing)
    {
        $this->thing = $thing;
    }
}

class FluentTest extends TestCase
{
    public function test_making_generic_fluent_class()
    {
        $instance = Foo::make('foo');

        $this->assertInstanceOf(Foo::class, $instance);
        $this->assertEquals('foo', $instance->arg);
    }

    public function test_setting_property_values()
    {
        $fluent = new class extends Fluent
        {
            public $foo;

            public $bar;
        };

        $instance = $fluent::make()->foo('one')->bar('two');

        $this->assertEquals('one', $instance->foo);
        $this->assertEquals('two', $instance->bar);
    }

    public function test_making_named_subclasses()
    {
        $instance = Foo::bar('baz');

        $this->assertInstanceOf(Bar::class, $instance);
        $this->assertEquals('baz', $instance->thing);
    }

    public function test_overwriting_a_parent_property_with_a_method()
    {
        $child = new class extends Fluent {
            public $foo = 1;
            
            public function foo()
            {
                return 'bar';
            }
        };

        define('FLUENT_TEST_CHILD_2', $child::class);

        $parent = new class extends Fluent
        {
            public static array $constructors = [
                'child' => FLUENT_TEST_CHILD_2,
            ];
        };

        $instance = $child::make();

        $bar = $instance->foo(2);

        $this->assertEquals(1, $instance->foo);
        $this->assertEquals('bar', $bar);
    }

    public function test_unknown_constructor_falls_back_to_property_assignment()
    {
        $fluent = new class extends Fluent {
            public $foo;
            public $bar;
        };

        $instance = $fluent::foo('foo')->bar('bar');

        $this->assertEquals('foo', $instance->foo);
        $this->assertEquals('bar', $instance->bar);
    }

    public function test_unknown_property_throws_fluent_exception()
    {
        $fluent = new class extends Fluent {};

        $instance = $fluent::make();

        $this->expectException(FluentException::class);

        $instance->foo();
    }
}
