<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Route;
use Bedard\Backend\Exceptions\ConfigValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_backend_from_directory()
    {
        $backend = Backend::create(__DIR__ . '/stubs/directory');

        $this->assertEquals('bar', $backend->controllers[0]->id);
        $this->assertEquals('foo', $backend->controllers[1]->id);
    }

    public function test_creating_backend_from_file()
    {
        $backend = Backend::create(
            __DIR__ . '/stubs/_blank.yaml',
        );

        $this->assertEquals(1, $backend->controllers->count());

        $this->assertEquals('_blank', $backend->controllers[0]->id);
    }

    public function test_duplicate_controller_ids_throws_exception()
    {
        $this->expectException(ConfigValidationException::class);

        $backend = Backend::create(__DIR__ . '/stubs/duplicates');
    }

    public function test_backend_controller_permissions()
    {
        $bob = $this->loginAsUserThatCan('read books');

        $backend = Backend::create(__DIR__ . '/stubs/controller-permissions');

        $this->assertEquals(2, $backend->controllers->count());
        $this->assertEquals('books', $backend->controllers[0]->id);
        $this->assertEquals('cars', $backend->controllers[1]->id);
    }

    public function test_collecting_nav_items()
    {
        $alice = $this->loginAsUserThatCan('read books', 'read shoes');

        $backend = Backend::create(__DIR__ . '/stubs/nav-items');

        $this->assertInstanceOf(Collection::class, $backend->nav);
        $this->assertEquals(2, $backend->nav->count());
        $this->assertEquals('backend.books', $backend->nav[0]->to);
        $this->assertEquals('backend.boots', $backend->nav[1]->to);
    }

    public function test_default_path_collision()
    {
        $this->expectException(ConfigValidationException::class);

        Backend::create(__DIR__ . '/stubs/controller-path-collision');
    }

    public function test_default_controller_id_and_path()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-default-id-path');

        $this->assertEquals('_index', $backend->controllers[0]->id);
        $this->assertNull($backend->controllers[0]->path);

        $this->assertEquals('books', $backend->controllers[1]->id);
        $this->assertEquals('books', $backend->controllers[1]->path);

        $this->assertEquals('vehicles', $backend->controllers[2]->id);
        $this->assertEquals('vehicles', $backend->controllers[2]->path);

        $this->assertEquals('shoes', $backend->controllers[3]->id);
        $this->assertEquals('footwear', $backend->controllers[3]->path);
    }

    public function test_finding_root_index()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-routing');

        $route = $backend->route(null, null);

        $this->assertInstanceOf(Route::class, $route);

        $this->assertEquals('foo', $route->id);
    }

    public function test_finding_root_page()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-routing');

        $route = $backend->route(null, 'about');

        $this->assertInstanceOf(Route::class, $route);

        $this->assertEquals('about', $route->id);
    }

    public function test_finding_controller_index()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-routing');

        $route = $backend->route('books', null);

        $this->assertEquals('books', $route->id);
    }

    public function test_controller_routing()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-routing');

        $route = $backend->route('books', 'authors');

        $this->assertEquals('authors', $route->id);
    }

    public function test_getting_a_specific_controller()
    {
        $backend = Backend::create(__DIR__ . '/stubs/controller-routing');

        $controller = $backend->controller('books');

        $this->assertEquals('books', $controller->id);
    }
}
