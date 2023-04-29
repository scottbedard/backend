<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\ChildConfig;
use Tests\Feature\Classes\KeyedArrayConfig;
use Tests\Feature\Classes\ParentConfig;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_config_normalize()
    {
        $class = new class extends Configuration {
            protected function normalize(): void
            {
                $config = $this->yaml;

                data_fill($config, 'foo', 'bar');

                $this->config = $config;
            }
        };
        
        // ensure normalize works with empty values
        $this->assertEquals('bar', $class::create()->get('foo'));

        // test existing data can be preserved
        $config = $class::create(['a' => 'b']);
        $this->assertEquals('b', $config->get('a'));
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function test_invalid_config_throws_exception()
    {
        $this->expectException(InvalidConfigurationException::class);

        $config = new class extends Configuration {
            protected array $rules = ['id' => 'required'];
        };
    }

    public function test_child_configuration()
    {
        $parent = ParentConfig::create([
            'thing' => 'hello world',
            'singular' => ['name' => 'thing'],
            'plural' => [
                ['name' => 'thing 1'],
                ['name' => 'thing 2'],
            ],
        ]);

        // properties should exist in the config
        $this->assertEquals('hello world', $parent->get('thing'));

        // singular items should return the instance
        $this->assertInstanceOf(ChildConfig::class, $parent->property('singular'));
        $this->assertEquals('thing', $parent->property('singular')->get('name'));

        // plural items should return a collection of instances
        $this->assertInstanceOf(Collection::class, $parent->property('plural'));
        $this->assertEquals('thing 1', $parent->property('plural')->get(0)->get('name'));
        $this->assertEquals('thing 2', $parent->property('plural')->get(1)->get('name'));
    }

    public function test_keyed_array_with_sequential_values()
    {
        $config = KeyedArrayConfig::create([
            'things' => [
                ['id' => 'foo', 'name' => 'hello'],
                ['id' => 'bar', 'name' => 'world'],
            ],
        ]);
        
        $this->assertEquals([
            'id' => 'foo',
            'name' => 'hello',
        ], $config->get('things.0'));

        $this->assertEquals([
            'id' => 'bar',
            'name' => 'world',
        ], $config->get('things.1'));
    }

    public function test_keyed_array_from_associative_values()
    {
        $config = KeyedArrayConfig::create([
            'things' => [
                'foo' => ['name' => 'hello'],
                'bar' => ['name' => 'world'],
            ],
        ]);

        $this->assertEquals([
            'id' => 'foo',
            'name' => 'hello',
        ], $config->get('things.0'));

        $this->assertEquals([
            'id' => 'bar',
            'name' => 'world',
        ], $config->get('things.1'));
    }

    public function test_ordering_values_from_keyed_array()
    {
        $config = KeyedArrayConfig::create([
            'things' => [
                'foo' => ['name' => 'hello', 'order' => 1],
                'bar' => ['name' => 'world', 'order' => 0],
            ],
        ]);

        $this->assertEquals([
            'id' => 'bar', // <- bar should be first because it's order is less than foo's
            'name' => 'world',
            'order' => 0,
        ], $config->get('things.0'));

        $this->assertEquals([
            'id' => 'foo',
            'name' => 'hello',
            'order' => 1,
        ], $config->get('things.1'));
    }
}
