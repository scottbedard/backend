<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
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
}
