<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'password' => Hash::make('secret'),
        ]);

        $admin->assignRole('super admin');

        $user = User::factory()
            ->count(50)
            ->create();

        Book::factory()
            ->count(50)
            ->create();
    }
}
