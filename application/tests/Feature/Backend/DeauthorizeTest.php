<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeauthorizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_deauthorizing_a_backend_permission()
    {
        $user = User::factory()->create();
        $foo = $user->backendPermissions()->create(['area' => 'foo', 'code' => 'create']);
        $bar = $user->backendPermissions()->create(['area' => 'bar', 'code' => 'create']);

        Backend::deauthorize($user, 'foo', 'create');
        
        $this->assertEquals(1, $user->backendPermissions()->count());
        $this->assertEquals($bar->id, $user->backendPermissions()->first()->id);
    }

    public function test_deauthorizing_an_entire_backend_area()
    {
        $user = User::factory()->create();
        $foo1 = $user->backendPermissions()->create(['area' => 'foo', 'code' => 'create']);
        $foo2 = $user->backendPermissions()->create(['area' => 'foo', 'code' => 'update']);
        $bar = $user->backendPermissions()->create(['area' => 'bar', 'code' => 'create']);

        Backend::deauthorize($user, 'foo');
        
        $this->assertEquals(1, $user->backendPermissions()->count());
        $this->assertEquals($bar->id, $user->backendPermissions()->first()->id);
    }

    public function test_deauthorizing_all_permissions()
    {
        $user = User::factory()->create();
        $user->backendPermissions()->create(['area' => 'foo', 'code' => 'all']);
        $user->backendPermissions()->create(['area' => 'bar', 'code' => 'create']);
        $user->backendPermissions()->create(['area' => 'bar', 'code' => 'update']);

        Backend::deauthorize($user);

        $this->assertEquals(0, $user->backendPermissions()->count());
    }
}
