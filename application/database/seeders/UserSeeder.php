<?php

namespace Database\Seeders;

use App\Models\User;
use Backend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // super admin
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);

        Backend::authorize($admin, 'super admin');

        // user manager
        $users = User::factory()->create([
            'email' => 'users@example.com',
            'name' => 'User Manager',
            'password' => Hash::make('password'),
        ]);

        Backend::authorize($users, 'manage users');

        // regular users
        User::factory()->count(100)->create();
    }
}
