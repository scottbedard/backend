<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Plugins\Plugin;
use Bedard\Backend\Config\Route;
use Tests\Feature\Classes\HelloPlugin;
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

        $this->assertEquals('bar', $route->plugin->foo);
    }

    public function test_rendering_a_plugin_view()
    {
        $req = request()->duplicate([
            'controller' => null,
            'route' => null,
        ]);

        $route = Route::create([
            'options' => [
                'name' => 'Alice',
            ],
            'plugin' => HelloPlugin::class,
        ]);

        $output = trim($route->plugin->handle($req)->render());

        $this->assertInstanceOf(HelloPlugin::class, $route->plugin);

        $this->assertEquals('Alice', $route->plugin->name);

        $this->assertEquals('<div>Hello Alice</div>', $output);
    }
}
