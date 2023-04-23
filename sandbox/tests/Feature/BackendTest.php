<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Classes\Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BackendTest extends TestCase
{
    public function test_load_single_backend_directory()
    {
        $config = Backend::from(__DIR__ . '/stubs')->config();

        $this->assertEquals(null, data_get($config, 'controllers._blank.model', 'empty'));
        $this->assertEquals(null, data_get($config, 'controllers._blank.nav'));
        $this->assertEquals(null, data_get($config, 'controllers._blank.path'));
        $this->assertEquals([], data_get($config, 'controllers._blank.permissions'));
        $this->assertEquals([], data_get($config, 'controllers._blank.routes'));
        $this->assertEquals([], data_get($config, 'controllers._blank.subnav'));
    }
    
    public function test_backend_controller_route_defaults()
    {
        $backend = Backend::from(__DIR__ . '/stubs');

        $index = $backend->route('backend.books.index');

        $this->assertNull($index['path']);
        $this->assertEquals('App\Models\Book', $index['model']);
        $this->assertEquals('Bedard\\Backend\\Plugins\\BladePlugin', $index['plugin']);
        $this->assertEquals('backend::missing-plugin', $index['options']['view']);
    }

    public function test_creating_backend_from_explicit_files()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_blank.yaml');

        $this->assertEquals(['_blank'], $backend->controllers()->keys()->toArray());
    }

    public function test_getting_a_specific_controller()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_blank.yaml');
        
        $controller = $backend->controller('backend._blank');
        
        $this->assertEquals('_blank', $controller['id']);
    }

    public function test_getting_a_specific_routes_controller()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_blank.yaml');
        
        $controller = $backend->controller('backend._blank.index');
        
        $this->assertEquals('_blank', $controller['id']);
    }

    public function test_getting_controller_navs()
    {
        $backend = Backend::from(__DIR__ . '/stubs/books.yaml');
        
        $nav = $backend->nav();
        
        $this->assertEquals([
            [
                'href' => null,
                'icon' => 'book',
                'label' => 'Books',
                'order' => 0,
                'permissions' => [],
                'to' => null,
            ],
        ], $nav);
    }

    public function test_getting_protected_controller_navs()
    {
        $backend = Backend::from(
            __DIR__ . '/stubs/_protected_nav.yaml',
            __DIR__ . '/stubs/_unprotected_nav.yaml',
        );

        Permission::firstOrCreate(['name' => 'read books']);
        
        // alice can read books
        $alice = User::factory()->create();
        $alice->givePermissionTo('read books');

        $this->assertEquals(2, count($backend->nav($alice)));

        // bob can't
        $bob = User::factory()->create();

        $this->assertEquals(1, count($backend->nav($bob)));
    }

    public function test_getting_protected_controller_subnavs()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_protected_nav.yaml');
        
        Permission::firstOrCreate(['name' => 'read categories']);
        
        $alice = User::factory()->create();

        $alice->givePermissionTo('read categories');

        $this->assertEquals(2, count($backend->subnav('backend._protected_nav.index', $alice)));

        $bob = user::factory()->create();

        $this->assertEquals(1, count($backend->subnav('backend._protected_nav.index', $bob)));
    }

    public function test_nav_to_route()
    {
        $nav = Backend::from(__DIR__ . '/stubs/_nav_to_route.yaml')->nav();

        $this->assertEquals(route('backend.admin.users'), $nav[0]['href']);
    }

    public function test_nav_to_path()
    {
        $nav = Backend::from(__DIR__ . '/stubs/_nav_to_path.yaml')->nav();

        $this->assertEquals('/backend/hello/foobar', $nav[0]['href']);
    }

    public function test_subnav_href()
    {
        $subnav = Backend::from(__DIR__ . '/stubs/_subnav_href.yaml')->subnav('backend._subnav_href.index');
        
        $this->assertEquals(route('backend.admin.users'), $subnav[0]['href']);
        $this->assertEquals('https://example.com', $subnav[1]['href']);
        $this->assertEquals('https://example.com', $subnav[2]['href']);
        $this->assertEquals('/backend/subnav/foobar', $subnav[3]['href']);
    }
}
