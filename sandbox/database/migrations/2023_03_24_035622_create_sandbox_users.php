<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createPermissions();

        $this->createUsers();
    }

    protected function createPermissions()
    {
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo(Permission::create(['name' => 'create users']));
        $manager->givePermissionTo(Permission::create(['name' => 'delete users']));
        $manager->givePermissionTo(Permission::create(['name' => 'read users']));
        $manager->givePermissionTo(Permission::create(['name' => 'update users']));
    }

    protected function createUsers()
    {
        // admin - all permissions
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'password' => Hash::make('secret'),
        ]);

        $admin->assignRole('super admin');

        // bob - no permissions
        $bob = User::factory()->create([
            'email' => 'bob@example.com',
            'name' => 'Bob',
            'password' => Hash::make('secret'),
        ]);

        // cindy - manager
        $cindy = User::factory()->create([
            'email' => 'cindy@example.com',
            'name' => 'Cindy',
            'password' => Hash::make('secret'),
        ]);

        $cindy->assignRole('manager');

        // filler
        User::factory(20)->create();
    }
};
