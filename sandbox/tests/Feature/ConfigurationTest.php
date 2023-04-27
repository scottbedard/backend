<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\InvalidConfigurationException;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_config_normalize()
    {
        $class = new class extends Configuration {
            protected function normalize(): void
            {
                $config = $this->config;

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
}
