<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Backend;
use Bedard\Backend\Exceptions\AlreadyAuthorizedException;
use Bedard\Backend\Models\BackendPermission;
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
}
