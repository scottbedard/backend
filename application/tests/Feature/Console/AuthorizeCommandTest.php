<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Console\AuthorizeCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AuthorizeCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorizing_a_permission()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --permission=whatever")
            ->expectsOutput(AuthorizeCommand::$messages['complete'])
            ->assertSuccessful();
            
        $this->assertTrue($user->hasPermissionTo('whatever'));
    }

    public function test_assigning_to_role()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --role=editor")
            ->expectsOutput(AuthorizeCommand::$messages['complete'])
            ->assertSuccessful();
    }

    public function test_authorizing_a_super_admin()
    {
        $user = User::factory()->create();

        Permission::create(['name' => 'super admin']);

        $this
            ->artisan("backend:authorize {$user->id} --super")
            ->expectsConfirmation(AuthorizeCommand::$messages['confirmSuperAdmin'], 'yes')
            ->expectsOutput(AuthorizeCommand::$messages['complete'])
            ->assertSuccessful();

        $this->assertTrue($user->hasPermissionTo('super admin'));
    }

    public function test_declining_super_admin_authorization()
    {
        $user = User::factory()->create();

        Permission::create(['name' => 'super admin']);

        $this
            ->artisan("backend:authorize {$user->id} --super")
            ->expectsConfirmation(AuthorizeCommand::$messages['confirmSuperAdmin'], 'no')
            ->expectsOutput(AuthorizeCommand::$messages['canceled'])
            ->assertSuccessful();

        $this->assertFalse($user->hasPermissionTo('super admin'));
    }

    public function test_authorizing_user_not_found()
    {
        User::where('id', 1)->delete();

        $this
            ->artisan("backend:authorize 1 --permission=foo --role=bar")
            ->expectsOutput(AuthorizeCommand::$messages['userNotFound'])
            ->assertFailed();
    }

    public function test_authorize_command_with_invalid_options()
    {
        $user = User::factory()->create();

        $this
            ->artisan("backend:authorize {$user->id} --permission=foo --role=bar")
            ->expectsOutput(AuthorizeCommand::$messages['invalidOptions'])
            ->assertFailed();
    }
}
