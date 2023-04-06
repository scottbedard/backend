<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Plugin;
use Tests\TestCase;

class PluginTest extends TestCase
{
    public function test_creating_a_plugin(): void
    {
        $plugin = new Plugin(
            config: [],
            controller: [],
            controllers: [],
            id: 'test',
            route: 'backend.test.index',
        );

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
