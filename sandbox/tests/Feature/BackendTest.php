<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Backend;
use App\Models\User;
// use Bedard\Backend\Configuration\Backend;
// use Bedard\Backend\Configuration\Route;
use Bedard\Backend\Exceptions\ConfigurationException;
// use Bedard\Backend\Plugins\BladePlugin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
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
        $this->expectException(ConfigurationException::class);

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

    // public function test_getting_a_specific_controller()
    // {
    //     $backend = Backend::create(__DIR__ . '/stubs/_blank.yaml');

    //     $controller = $backend->controller('_blank');
        
    //     $this->assertEquals('_blank', $controller->get('id'));
    // }

    // public function test_getting_controller_from_route_id()
    // {
    //     $backend = Backend::create(__DIR__ . '/stubs/books.yaml');
        
    //     $route = $backend->route('backend.books.create');

    //     $this->assertEquals('create', $route->get('id'));
    //     $this->assertEquals('books', $route->controller()->get('id'));
    // }

    // public function test_getting_index_route_from_controller_id()
    // {
    //     $backend = Backend::create(__DIR__ . '/stubs/books.yaml');
        
    //     $route = $backend->route('backend.books');

    //     $this->assertEquals('index', $route->get('id'));
    //     $this->assertEquals('books', $route->controller()->get('id'));
    // }

    // public function test_default_controller_paths()
    // {
    //     $backend = Backend::create(
    //         __DIR__ . '/stubs/_blank.yaml',
    //         __DIR__ . '/stubs/books.yaml',
    //     );
        
    //     $this->assertNull($backend->controller('_blank')->path());
    //     $this->assertEquals('books', $backend->controller('books')->path());
    // }

    // public function test_ordered_controller_navs()
    // {
    //     $backend = Backend::create(
    //         __DIR__ . '/stubs/_nav_order_1.yaml',
    //         __DIR__ . '/stubs/_nav_order_2.yaml',
    //         __DIR__ . '/stubs/_nav_double.yaml',
    //     );
        
    //     $nav = $backend->nav();

    //     $this->assertInstanceOf(Collection::class, $nav);
    //     $this->assertEquals(4, $nav->count());
        
    //     $this->assertEquals('Zero', $nav->get('0')->get('label'));     
    //     $this->assertEquals('One', $nav->get('1')->get('label'));     
    //     $this->assertEquals('Two', $nav->get('2')->get('label'));     
    //     $this->assertEquals('Three', $nav->get('3')->get('label'));        
    // }

    // public function test_getting_protected_subnavs()
    // {
    //     // "things" are required for controller, "categories" are required for subnav
    //     $readThings = Permission::firstOrCreate(['name' => 'read things']);
    //     $readCategories = Permission::firstOrCreate(['name' => 'read categories']);

    //     // alice has no permissions
    //     $alice = User::factory()->create();

    //     // bob has controller permissions
    //     $bob = User::factory()->create();
    //     $bob->givePermissionTo($readThings);

    //     // cindy has controller and subnav permissions
    //     $cindy = User::factory()->create();
    //     $cindy->givePermissionTo($readThings);
    //     $cindy->givePermissionTo($readCategories);

    //     // alice should have no subnav items
    //     $ctrl = Backend::create(__DIR__ . '/stubs/_protected_nav.yaml')->controller('_protected_nav');

    //     $this->assertEquals(0, $ctrl->subnav($alice)->count());

    //     // bob can only see unprotected subnav
    //     $this->assertEquals(1, $ctrl->subnav($bob)->count());
    //     $this->assertEquals('Authors', $ctrl->subnav($bob)->first()->get('label'));

    //     // cindy can see protected subnav
    //     $this->assertEquals(2, $ctrl->subnav($cindy)->count());
    //     $this->assertEquals('Authors', $ctrl->subnav($cindy)->first()->get('label'));
    //     $this->assertEquals('Categories', $ctrl->subnav($cindy)->last()->get('label'));
    // }
}
