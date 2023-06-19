<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use Bedard\Backend\Classes\Bouncer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedUsers();
    }

    /**
     * Seed users
     *
     * @return void
     */
    protected function seedUsers(): void
    {
        $admin = Permission::create(['name' => 'admin']);
        $booksCrud = Bouncer::crud('books', 'books.manager');
        $usersCrud = Bouncer::crud('users', 'users.manager');

        // create super admin
        $superAdmin = User::factory()->create([
            'email' => 'super-admin@example.com',
            'name' => 'Super admin',
            'password' => Hash::make('secret'),
        ]);

        $superAdmin->assignRole(config('backend.super_admin_role'));

        // alice, the librarian
        // she manages the books and has total access to them
        $alice = User::factory()->create([
            'email' => 'alice@example.com',
            'name' => 'Alice',
            'password' => Hash::make('secret'),
        ]);

        $alice->assignRole('books.manager');

        // bob is a music teacher
        // he can read users and can manage books, but cannot delete them
        $bob = User::factory()->create([
            'email' => 'bob@example.com',
            'name' => 'Bob',
            'password' => Hash::make('secret'),
        ]);

        $bob->givePermissionTo('admin', 'books.create', 'books.read', 'books.update', 'users.read');

        // cindy can only access the dashboard
        $cindy = User::factory()->create([
            'email' => 'cindy@example.com',
            'name' => 'Cindy',
            'password' => Hash::make('secret'),
        ]);

        $cindy->givePermissionTo('admin');

        // dave is a sketchy parent
        // he tries to access the backend, but he doesn't work here
        $dave = User::factory()->create([
            'email' => 'dave@example.com',
            'name' => 'Dave',
            'password' => Hash::make('secret'),
        ]);

        // create a few dozen random users
        $user = User::factory()
            ->count(50)
            ->create();

        Book::factory()
            ->count(50)
            ->create();
    }
}
