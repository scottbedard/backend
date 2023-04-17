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
    public function test_backend_controller_defaults()
    {
        $backend = new Backend([__DIR__ . '/stubs']);

        $this->assertEquals(null, data_get($backend->config, 'controllers._blank.model', 'empty'));
        $this->assertEquals([], data_get($backend->config, 'controllers._blank.nav'));
        $this->assertEquals(null, data_get($backend->config, 'controllers._blank.path'));
        $this->assertEquals([], data_get($backend->config, 'controllers._blank.permissions'));
        $this->assertEquals([], data_get($backend->config, 'controllers._blank.routes'));
        $this->assertEquals([], data_get($backend->config, 'controllers._blank.subnav'));
    }
    
    public function test_backend_controller_route_defaults()
    {
        $backend = new Backend([__DIR__ . '/stubs']);

        $index = $backend->route('backend.books.index');

        $this->assertNull($index['path']);
        $this->assertEquals('App\Models\Book', $index['model']);
        $this->assertEquals('Bedard\\Backend\\Plugins\\BladePlugin', $index['plugin']);
        $this->assertEquals('backend::missing-plugin', $index['options']['view']);
    }

    public function test_creating_backend_from_explicit_files()
    {
        $backend = new Backend([__DIR__ . '/stubs/_blank.yaml']);

        $this->assertEquals(['_blank'], $backend->controllers()->keys()->toArray());
    }

    public function test_getting_a_specific_controller()
    {
        $backend = new Backend([__DIR__ . '/stubs/_blank.yaml']);
        
        $controller = $backend->controller('backend._blank');
        
        $this->assertEquals('_blank', $controller['id']);
    }

    public function test_getting_a_specific_routes_controller()
    {
        $backend = new Backend(__DIR__ . '/stubs/_blank.yaml');
        
        $controller = $backend->controller('backend._blank.index');
        
        $this->assertEquals('_blank', $controller['id']);
    }

    public function test_getting_controller_navs()
    {
        $backend = new Backend(__DIR__ . '/stubs/books.yaml');
        
        $nav = $backend->nav('backend.books.index');
        
        $this->assertEquals([
            [
                'href' => null,
                'icon' => 'book',
                'label' => 'Books',
                'order' => 0,
                'permissions' => [],
            ],
        ], $nav);
    }

    public function test_getting_protected_controller_navs()
    {
        $backend = new Backend([
            __DIR__ . '/stubs/_protected_nav.yaml',
            __DIR__ . '/stubs/_unprotected_nav.yaml',
        ]);

        Permission::firstOrCreate(['name' => 'read books']);
        
        // alice can read books
        $alice = User::factory()->create();
        $alice->givePermissionTo('read books');

        $this->assertEquals(2, count($backend->nav($alice)));

        // bob can't
        $bob = user::factory()->create();

        $this->assertEquals(1, count($backend->nav($bob)));
    }

    public function test_getting_protected_controller_subnavs()
    {
        $backend = new Backend(__DIR__ . '/stubs/_protected_nav.yaml');
        
        Permission::firstOrCreate(['name' => 'read categories']);
        
        $alice = User::factory()->create();

        $alice->givePermissionTo('read categories');

        $this->assertEquals(2, count($backend->subnav('backend._protected_nav.index', $alice)));

        $bob = user::factory()->create();

        $this->assertEquals(1, count($backend->subnav('backend._protected_nav.index', $bob)));
    }
}
