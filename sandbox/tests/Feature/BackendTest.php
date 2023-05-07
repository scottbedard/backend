<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Configuration\Backend;
use Bedard\Backend\Exceptions\ConfigurationException;
use Bedard\Backend\Plugins\BladePlugin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BackendTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_getting_controllers_and_navs()
    {
        $readBooks = Permission::firstOrCreate(['name' => 'read books']);
        $readCategories = Permission::firstOrCreate(['name' => 'read categories']);
        $readThings = Permission::firstOrCreate(['name' => 'read things']);
        $superAdmin = Permission::firstOrCreate(['name' => config('backend.super_admin_role')]);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($readThings);
        $admin->givePermissionTo($readBooks);

        // alice has no permissions
        $alice = User::factory()->create();

        // bob can only access the controller
        $bob = User::factory()->create();
        $bob->givePermissionTo($readThings);

        // cindy can read books
        $cindy = User::factory()->create();
        $cindy->givePermissionTo($readThings);
        $cindy->givePermissionTo($readBooks);

        // dave can read everything
        $dave = User::factory()->create();
        $dave->givePermissionTo($readThings);
        $dave->givePermissionTo($readBooks);
        $dave->givePermissionTo($readCategories);

        // emily is a super-admin, and can access everything
        $emily = User::factory()->create();
        $emily->givePermissionTo($superAdmin);

        // frank can read things and books via a role
        $frank = User::factory()->create();
        $frank->assignRole($admin);

        // everyone but alice can access the controller
        $backend = Backend::create(__DIR__ . '/stubs/_protected_nav.yaml');
        
        $this->assertEquals(0, $backend->controllers($alice)->count());
        $this->assertEquals(1, $backend->controllers($bob)->count());
        $this->assertEquals(1, $backend->controllers($cindy)->count());
        $this->assertEquals(1, $backend->controllers($dave)->count());
        $this->assertEquals(1, $backend->controllers($emily)->count());
        $this->assertEquals(1, $backend->controllers($frank)->count());

        // alice has no nav
        $this->assertEquals(0, $backend->nav($alice)->count());

        // bob can only access unprotected navs
        $bobNav = $backend->nav($bob);
        $this->assertEquals(1, $bobNav->count());
        $this->assertEquals('Home', $bobNav->first()->get('label'));

        // cindy and dave can access protected nav
        $cindyNav = $backend->nav($cindy);
        $this->assertEquals(2, $cindyNav->count());
        $this->assertEquals('Home', $cindyNav->first()->get('label'));
        $this->assertEquals('Books', $cindyNav->last()->get('label'));

        $daveNav = $backend->nav($dave);
        $this->assertEquals(2, $daveNav->count());
        $this->assertEquals('Home', $daveNav->first()->get('label'));
        $this->assertEquals('Books', $daveNav->last()->get('label'));

        // emily is super admin and can access everything
        $emilyNav = $backend->nav($emily);
        $this->assertEquals(2, $emilyNav->count());
        $this->assertEquals('Home', $emilyNav->first()->get('label'));
        $this->assertEquals('Books', $emilyNav->last()->get('label'));

        // frank is admin and can access everything
        $frankNav = $backend->nav($frank);
        $this->assertEquals('Home', $frankNav->first()->get('label'));
        $this->assertEquals('Books', $frankNav->last()->get('label'));
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
