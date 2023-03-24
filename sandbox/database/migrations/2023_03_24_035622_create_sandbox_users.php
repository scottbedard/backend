<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // admin - all permissions
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'password' => Hash::make('secret'),
        ]);

        $admin->assignRole('super admin');

        // bob - no permissions
        User::factory()->create([
            'email' => 'bob@example.com',
            'name' => 'Bob',
            'password' => Hash::make('secret'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
