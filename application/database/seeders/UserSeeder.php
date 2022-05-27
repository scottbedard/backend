<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ])->backendPermissions()->create([
            'area' => 'all',
            'code' => 'all',
        ]);

        User::factory()->count(10)->create();
    }
}
