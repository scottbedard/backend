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

    public function test_deauthorizing_a_permission()
    {
        $user = User::factory()->create();
        
        $user->permissions()->create([
            'name' => 'foo',
        ]);

        $this->assertTrue($user->hasPermissionTo('foo'));

        $this
            ->artisan("backend:deauthorize {$user->id} --permission=foo")
            ->expectsOutput(DeauthorizeCommand::$messages['complete'])
            ->assertSuccessful();

        $user->refresh();
            
        $this->assertFalse($user->hasPermissionTo('foo'));
    }

    public function test_deauthorize_a_role()
    {
        $user = User::factory()->create();
        
        $role = $user->roles()->create([
            'name' => 'foo',
        ]);

        $this->assertTrue($user->hasRole($role));

        $this
            ->artisan("backend:deauthorize {$user->id} --role=foo")
            ->expectsOutput(DeauthorizeCommand::$messages['complete'])
            ->assertSuccessful();

        $user->refresh();

        $this->assertFalse($user->hasRole($role));
    }
}
