<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Console\AssignRoleCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AssignRoleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigning_role_to_user()
    {
        $user = User::factory()->create();

        $this->artisan('backend:assign-role ' . $user->id . ' "test"')
            ->assertExitCode(0);

        $this->assertEquals(1, $user->roles()->count());

        $this->assertTrue($user->hasRole('test'));
    }

    public function test_assigning_super_admin_role_confirmed()
    {
        $user = User::factory()->create();

        $this->artisan('backend:assign-role ' . $user->id . ' "' . config('backend.super_admin_role') . '"')
            ->expectsConfirmation(AssignRoleCommand::$confirm, 'yes')
            ->assertExitCode(0);

        $this->assertEquals(1, $user->roles()->count());

        $this->assertTrue($user->hasRole(config('backend.super_admin_role')));
    }

    public function test_assigning_super_admin_role_declined(): void
    {
        $user = User::factory()->create();

        $this->artisan('backend:assign-role ' . $user->id . ' "' . config('backend.super_admin_role') . '"')
            ->expectsConfirmation(AssignRoleCommand::$confirm, 'no')
            ->assertExitCode(1);
        
        $this->assertEquals(0, $user->roles()->count());
    }
}
