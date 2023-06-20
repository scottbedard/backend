<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => config('backend.super_admin_role')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
