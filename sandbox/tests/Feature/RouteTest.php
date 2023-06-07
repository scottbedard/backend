<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Plugins\Plugin;
use Bedard\Backend\Config\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_instantiating_route_plugin()
    {
        $route = Route::create([
            'options' => [
                'foo' => 'bar',
            ],
            'plugin' => Plugin::class,
        ]);
        
        $this->assertInstanceOf(Plugin::class, $route->plugin);

        $this->assertEquals([
            'foo' => 'bar',
        ], $route->plugin->__config);
    }
}
