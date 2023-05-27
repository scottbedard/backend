<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Controller;
use Bedard\Backend\Configuration\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function test_route_sets_path_if_none_present()
    {
        $route = Route::create(['id' => 'foo_bar']);

        $this->assertEquals('foo-bar', $route->get('path'));
    }

    public function test_route_uses_null_path()
    {
        $route = Route::create(['id' => 'foo', 'path' => null]);

        $this->assertNull($route->get('path'));
    }

    public function test_route_uses_explicit_path()
    {
        $route = Route::create(['id' => 'foo', 'path' => 'bar']);

        $this->assertEquals('bar', $route->get('path'));
    }

    public function test_route_inherits_parent_permissions()
    {
        $controller = Controller::create([
            'id' => '_test',
            'routes' => [
                [
                    'id' => 'foo',
                ],
                [
                    'id' => 'bar',
                    'permissions' => ['two'],
                ],
            ],
            'permissions' => ['one'],
        ]);

        $this->assertEquals(['one'], $controller->get('routes.0.permissions'));
        $this->assertEquals(['one', 'two'], $controller->get('routes.1.permissions'));
    }
}
