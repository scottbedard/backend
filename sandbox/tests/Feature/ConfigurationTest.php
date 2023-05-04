<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\ChildConfig;
use Tests\Feature\Classes\DefaultValuesConfig;
use Tests\Feature\Classes\ParentConfig;
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

    public function test_prop_definitions()
    {
        $config = ParentConfig::create([
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
        ], $config->config);
    }

    public function test_setting_default_values()
    {
        $config = DefaultValuesConfig::create([
            'foo' => 'some explicit value',
        ]);

        $this->assertEquals('some explicit value', $config->get('foo'));
        $this->assertEquals('world', $config->get('hello'));
        $this->assertEquals([], $config->get('things'));
        $this->assertNull($config->get('blank'));
    }
}
