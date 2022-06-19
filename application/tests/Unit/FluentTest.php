<?php

namespace Tests\Unit;

use Bedard\Backend\Exceptions\FluentException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Stubs\Child;
use Tests\Unit\Stubs\Example;

class FluentTest extends TestCase
{
    public function test_constructing_fluent_instance()
    {
        $instance = Example::make('test');

        $this->assertEquals('test', $instance->constructed);
    }

    public function test_static_constuctor_aliases()
    {
        $instance = Example::child('test');

        $this->assertInstanceOf(Child::class, $instance);

        $this->assertEquals('test', $instance->attributes['id']);
    }

    public function test_setting_plain_attribute_by_assignment()
    {
        $instance = Example::make();

        $instance->plain = 'test';

        $this->assertEquals('test', $instance->attributes['plain']);
    }

    public function test_setting_computed_attribute_by_assignment()
    {
        $instance = Example::make();

        $instance->computed = 'test';

        $this->assertEquals('TEST', $instance->attributes['computed']);
    }

    public function test_setting_computed_attribute_from_static_call()
    {
        $instance = Example::computed('test');

        $this->assertEquals('TEST', $instance->attributes['computed']);
    }

    public function test_setting_computed_attribute_from_dynamic_call()
    {
        $instance = Example::make()->computed('test');

        $this->assertEquals('TEST', $instance->attributes['computed']);
    }

    public function test_setting_plain_attribute_from_static_call()
    {
        $instance = Example::plain('test');

        $this->assertEquals('test', $instance->attributes['plain']);
    }

    public function test_setting_plain_attribute_from_dynamic_call()
    {
        $instance = Example::make()->plain('test');

        $this->assertEquals('test', $instance->attributes['plain']);
    }

    public function test_setting_unknown_attribute_from_static_call()
    {
        $this->expectException(FluentException::class);

        Example::unknown('foo');
    }

    public function test_setting_unknown_attribute_from_dynamic_call()
    {
        $this->expectException(FluentException::class);

        Example::make()->unknown('foo');
    }

    public function test_getting_plain_value()
    {
        $instance = Example::plain('hello');

        $this->assertEquals('hello', $instance->plain);
    }

    public function test_getting_computed_value()
    {
        $instance = Example::computed('hello');

        $this->assertEquals('~HELLO~', $instance->computed);
    }

    public function test_toggling_boolean_attribute_from_static_call()
    {
        $instance = Example::flagged();

        $this->assertTrue($instance->attributes['flagged']);
    }

    public function test_toggling_boolean_attribute_from_dynamic_call()
    {
        $instance = Example::make()->flagged();

        $this->assertTrue($instance->attributes['flagged']);
    }

    public function test_inheritting_parent_attrs()
    {
        $parent = Example::make();

        $child = Child::make();
        
        foreach (array_keys($parent->attributes) as $attr) {
            $this->assertArrayHasKey($attr, $child->attributes);
        }

        foreach (array_keys($child->attributes) as $attr) {
            $this->assertArrayHasKey($attr, $child->attributes);
        }
    }

    public function test_has_attribute()
    {
        $instance = Example::make();

        $this->assertTrue($instance->hasAttribute('flagged'));

        $this->assertFalse($instance->hasAttribute('never'));
    }

    public function test_providing_data_to_child_instances()
    {
        $grandchild = Example::make();

        $child = Example::items([$grandchild]);

        $parent = Example::items([$child]);

        $parent->provide(['foo' => 'bar']);

        $this->assertEquals('bar', $parent->data['foo']);
        $this->assertEquals('bar', $child->data['foo']);
        $this->assertEquals('bar', $grandchild->data['foo']);
    }
}