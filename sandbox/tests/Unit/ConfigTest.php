<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Config;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Classes\Defaults;
use Tests\Unit\Classes\Noop;
use Tests\Unit\Classes\ParentOfSingleChild;
use Tests\Unit\Traits\DynamicTestAttribute;

class ConfigTest extends TestCase
{
    public function test_static_config_constructor()
    {
        $this->assertInstanceOf(Noop::class, Noop::create());
    }

    public function test_config_overwrites_defaults()
    {
        $config = Defaults::create([
            'hello' => 'world',
            'overwrite' => 'new value',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
            'hello' => 'world',
            'overwrite' => 'new value',
        ], $config->config);
    }
    
    public function test_dynamic_default_values()
    {
        $config = new class extends Config
        {
            use DynamicTestAttribute;

            public function getDefaultAttributes(): array
            {
                return [
                    'overwrite' => 'new value',
                ];
            }
        };

        $this->assertEquals([
            'overwrite' => 'new value',
            'test' => 'hello',
            'multi_word' => 'world',
        ], $config->config);
    }

    public function test_custom_attribute_setter()
    {
        $config = new class extends Config
        {
            public function getDefaultAttributes(): array
            {
                return [
                    'foo' => 'bar',
                    'multi_word' => 1,
                ];
            }

            public function getDefaultDynamicAttribute()
            {
                return 'hello';
            }

            public function setDynamicAttribute($value)
            {
                return $value . ' world';
            }

            public function setFooAttribute($value)
            {
                return strtoupper($value);
            }

            public function setMultiWordAttribute($value)
            {
                return $value * 2;
            }
        };

        $this->assertEquals([
            'dynamic' => 'hello world',
            'foo' => 'BAR',
            'multi_word' => 2,
        ], $config->data);
    }

    public function test_parent_of_single_child()
    {
        $class = ParentOfSingleChild::create([
            'child' => ['name' => 'alice'],
        ]);

        $this->assertInstanceOf(Noop::class, $class->get('child'));

        $this->assertEquals('alice', $class->get('child.name'));
    }
}
