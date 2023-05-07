<?php

namespace Tests\Feature;

// use App\Models\User;
// use Bedard\Backend\Classes\Backend;
// use Bedard\Backend\Configuration\Controller;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Support\Collection;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use Bedard\Backend\Configuration\Backend;
use Bedard\Backend\Exceptions\ConfigurationException;
use Bedard\Backend\Plugins\BladePlugin;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BackendTest extends TestCase
{
    public function test_creating_backend_from_directory()
    {
        $backend = Backend::create(__DIR__ . '/stubs/directory');

        $this->assertEquals('foo', $backend->controller('foo')->get('id'));
        $this->assertEquals('bar', $backend->controller('bar')->get('id'));
    }

    public function test_creating_backend_from_file()
    {
        $backend = Backend::create(
            __DIR__ . '/stubs/_blank.yaml',
        );
        
        $this->assertTrue($backend->get('controllers')->count() === 1);
        $this->assertEquals('_blank', $backend->controller('_blank')->get('id'));
    }

    public function test_duplicate_controller_ids_throws_exception()
    {
        $this->expectException(ConfigurationException::class);

        $backend = Backend::create(
            __DIR__ . '/stubs/_duplicate_id_a.yaml',
            __DIR__ . '/stubs/_duplicate_id_b.yaml',
        );
    }
    
    public function test_backend_controller_route_defaults()
    {
        $backend = Backend::create(__DIR__ . '/stubs/books.yaml');

        $index = $backend->route('backend.books.index');

        $this->assertNull($index->get('path'));
        $this->assertEquals('App\Models\Book', $index->get('model'));
        $this->assertInstanceOf(BladePlugin::class, $index->plugin());
        $this->assertEquals([], $index->get('options'));
        $this->assertEquals($index, $index->plugin()->parent);
    }

    public function test_getting_all_controllers()
    {
        $backend = Backend::create(__DIR__ . '/stubs/books.yaml');

        $this->assertEquals(1, $backend->controllers()->count());
        $this->assertEquals('books', $backend->controllers()->first()->get('id'));
    }

    public function test_getting_a_specific_controller()
    {
        $backend = Backend::create(__DIR__ . '/stubs/_blank.yaml');

        $controller = $backend->controller('_blank');
        
        $this->assertEquals($backend, $controller->parent);
        $this->assertEquals('_blank', $controller->get('id'));
    }

    public function test_route_getting_data_from_controller()
    {
        $backend = Backend::create(__DIR__ . '/stubs/books.yaml');
        
        $route = $backend->route('backend.books.index');

        $this->assertEquals('books', $route->controller()->get('id'));
    }

    public function test_default_controller_paths()
    {
        $backend = Backend::create(
            __DIR__ . '/stubs/_blank.yaml',
            __DIR__ . '/stubs/books.yaml',
        );
        
        $this->assertNull($backend->controller('_blank')->path());
        $this->assertEquals('books', $backend->controller('books')->path());
    }

    public function test_ordered_controller_navs()
    {
        $backend = Backend::create(
            __DIR__ . '/stubs/_nav_order_1.yaml',
            __DIR__ . '/stubs/_nav_order_2.yaml',
            __DIR__ . '/stubs/_nav_double.yaml',
        );
        
        $nav = $backend->nav();

        $this->assertInstanceOf(Collection::class, $nav);
        $this->assertEquals(4, $nav->count());
        
        $this->assertEquals('Zero', $nav->get('0')->get('label'));     
        $this->assertEquals('One', $nav->get('1')->get('label'));     
        $this->assertEquals('Two', $nav->get('2')->get('label'));     
        $this->assertEquals('Three', $nav->get('3')->get('label'));        
    }

    // public function test_getting_controller_navs()
    // {
    //     $backend = Backend::from(__DIR__ . '/stubs/books.yaml');
        
    //     $nav = $backend->nav();
        
    //     $this->assertEquals([
    //         [
    //             'href' => null,
    //             'icon' => 'book',
    //             'label' => 'Books',
    //             'order' => 0,
    //             'permissions' => [],
    //             'to' => null,
    //         ],
    //     ], $nav);
    // }

    // public function test_getting_protected_controller_navs()
    // {
    //     $backend = Backend::from(
    //         __DIR__ . '/stubs/_protected_nav.yaml',
    //         __DIR__ . '/stubs/_unprotected_nav.yaml',
    //     );

    //     Permission::firstOrCreate(['name' => 'read books']);
        
    //     // alice can read books
    //     $alice = User::factory()->create();
    //     $alice->givePermissionTo('read books');

    //     $this->assertEquals(2, count($backend->nav($alice)));

    //     // bob can't
    //     $bob = User::factory()->create();

    //     $this->assertEquals(1, count($backend->nav($bob)));
    // }

    // public function test_getting_protected_controller_subnavs()
    // {
    //     $backend = Backend::from(__DIR__ . '/stubs/_protected_nav.yaml');
        
    //     Permission::firstOrCreate(['name' => 'read categories']);
        
    //     $alice = User::factory()->create();

    //     $alice->givePermissionTo('read categories');

    //     $this->assertEquals(2, count($backend->subnav('backend._protected_nav.index', $alice)));

    //     $bob = user::factory()->create();

    //     $this->assertEquals(1, count($backend->subnav('backend._protected_nav.index', $bob)));
    // }

    // public function test_nav_to_route()
    // {
    //     $nav = Backend::from(__DIR__ . '/stubs/_nav_to_route.yaml')->nav();

    //     $this->assertEquals(route('backend.admin.users'), $nav[0]['href']);
    // }

    // public function test_nav_to_path()
    // {
    //     $nav = Backend::from(__DIR__ . '/stubs/_nav_to_path.yaml')->nav();

    //     $this->assertEquals('/backend/hello/foobar', $nav[0]['href']);
    // }

    // public function test_nav_order()
    // {
    //     $nav1 = Backend::from(
    //         __DIR__ . '/stubs/_nav_order_1.yaml',
    //         __DIR__ . '/stubs/_nav_order_2.yaml',
    //     )->nav();

    //     $this->assertEquals('First', $nav1[0]['label']);
    //     $this->assertEquals('Second', $nav1[1]['label']);

    //     $nav2 = Backend::from(
    //         __DIR__ . '/stubs/_nav_order_2.yaml', // <- order of navs is different
    //         __DIR__ . '/stubs/_nav_order_1.yaml',
    //     )->nav();

    //     $this->assertEquals('First', $nav2[0]['label']); // <- final order should be the same
    //     $this->assertEquals('Second', $nav2[1]['label']);
    // }

    // public function test_subnav_href()
    // {
    //     $subnav = Backend::from(__DIR__ . '/stubs/_subnav_href.yaml')->subnav('backend._subnav_href.index');
        
    //     $this->assertEquals(route('backend.admin.users'), $subnav[0]['href']);
    //     $this->assertEquals('https://example.com', $subnav[1]['href']);
    //     $this->assertEquals('https://example.com', $subnav[2]['href']);
    //     $this->assertEquals('/backend/subnav/foobar', $subnav[3]['href']);
    // }
}
