<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\BlankConfig;
use Tests\Feature\Classes\TestConfig;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_invalid_config_throws_exception()
    {
        $this->expectException(InvalidConfigurationException::class);

        $config = new class extends Configuration {
            public array $rules = ['id' => 'required'];
        };
    }

    public function test_default_values_and_prop_normalizing()
    {
        $config = TestConfig::create([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);

        $this->assertEquals([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                ['id' => 'foo', 'name' => 'four'],
                ['id' => 'bar', 'name' => 'five'],
            ],
            'other_child' => null,
            'other_children' => [],
            'other_keyed_children' => [],
            'array' => [],
            'bool' => true,
            'int' => 1,
            'null' => null,
            'string' => 'string',
        ], $config->config);
    }

    public function test_instantiating_props_and_data()
    {
        $config = TestConfig::create([
            'string' => 'hello',
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);

        $this->assertInstanceOf(Collection::class, $config->get('children'));
        $this->assertInstanceOf(Collection::class, $config->get('keyed_children'));
        $this->assertInstanceOf(Collection::class, $config->get('other_children'));
        $this->assertInstanceOf(Collection::class, $config->get('other_keyed_children'));

        $this->assertInstanceOf(BlankConfig::class, $config->get('children.0'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('children.1'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('keyed_children.0'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('keyed_children.1'));
        
        $this->assertEquals('hello', $config->get('string'));
        $this->assertEquals('two', $config->get('children.0.name'));
        $this->assertEquals('three', $config->get('children.1.name'));
        $this->assertEquals('foo', $config->get('keyed_children.0.id'));
        $this->assertEquals('four', $config->get('keyed_children.0.name'));
        $this->assertEquals('bar', $config->get('keyed_children.1.id'));
        $this->assertEquals('five', $config->get('keyed_children.1.name'));
    }
}
