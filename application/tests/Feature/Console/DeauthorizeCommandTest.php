<?php

namespace Tests\Feature;

use App\Models\User;
use Backend;
use Bedard\Backend\Console\DeauthorizeCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeauthorizeCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_revoking_a_permission()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'foo', 'create');
        Backend::authorize($user, 'foo', 'update');
        Backend::authorize($user, 'bar', 'create');

        $this
            ->artisan("backend:deauthorize {$user->id} --area=foo --code=create")
            ->assertSuccessful();

        $this->assertEquals(2, $user->backendPermissions()->count());
        $this->assertTrue($user->backendPermissions()->area('foo')->code('update')->exists());
        $this->assertTrue($user->backendPermissions()->area('bar')->exists());
    }

    public function test_revoking_super_admin_confirmation_accepted()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'all', 'all');

        $this
            ->artisan("backend:deauthorize {$user->id} --super")
            ->expectsConfirmation(DeauthorizeCommand::$confirmation, 'yes')
            ->assertSuccessful();

        $this->assertEquals(0, $user->backendPermissions()->count());
    }

    public function test_creating_super_admin_confirmation_declined()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'all', 'all');

        $this
            ->artisan("backend:deauthorize {$user->id} --super")
            ->expectsConfirmation(DeauthorizeCommand::$confirmation, 'no')
            ->assertFailed();

        $this->assertEquals(1, $user->backendPermissions()->count());
    }
}
