<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\ChildConfig;
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
            'keyed' => [
                'first' => ['name' => 'foo'],
                'second' => ['name' => 'bar'],
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

        // keyed arrays are converted to a collection
        $this->assertInstanceOf(Collection::class, $parent->property('keyed'));
        $this->assertEquals('foo', $parent->property('keyed')->get(0)->get('name'));
        $this->assertEquals('first', $parent->property('keyed')->get(0)->get('id'));
        $this->assertEquals('bar', $parent->property('keyed')->get(1)->get('name'));
        $this->assertEquals('second', $parent->property('keyed')->get(1)->get('id'));
    }

    public function test_keyed_array_with_sequential_value()
    {
        $parent = ParentConfig::create([
            'keyed' => [
                ['id' => 'first', 'name' => 'foo'],
                ['id' => 'second', 'name' => 'bar'],
            ],
        ]);

        $this->assertInstanceOf(Collection::class, $parent->property('keyed'));
        $this->assertEquals('foo', $parent->property('keyed')->get(0)->get('name'));
        $this->assertEquals('first', $parent->property('keyed')->get(0)->get('id'));
        $this->assertEquals('bar', $parent->property('keyed')->get(1)->get('name'));
        $this->assertEquals('second', $parent->property('keyed')->get(1)->get('id'));
    }
}
