<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Console\AuthorizeCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizeCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_permission()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --area=whatever --code=create")
            ->assertSuccessful();

        $permission = $user->backendPermissions()->firstOrFail();

        $this->assertEquals('whatever', $permission->area);
        $this->assertEquals('create', $permission->code);
    }

    public function test_creating_super_admin_confirmation_accepted()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --super")
            ->expectsConfirmation(AuthorizeCommand::$confirmation, 'yes')
            ->assertSuccessful();

        $permission = $user->backendPermissions()->firstOrFail();

        $this->assertEquals('all', $permission->area);
        $this->assertEquals('all', $permission->code);
    }

    public function test_creating_super_admin_confirmation_declined()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --super")
            ->expectsConfirmation(AuthorizeCommand::$confirmation, 'no')
            ->assertFailed();

        $this->assertEquals(0, $user->backendPermissions()->count());
    }
}
