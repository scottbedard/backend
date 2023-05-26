<?php

namespace Tests\Unit;

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
}
