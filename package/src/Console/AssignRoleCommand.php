<?php

namespace Bedard\Backend\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRoleCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant user a role';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:assign-role {userId} {role}
            {--force : Skip safety checks}
    ';

    /**
     * Confirmation message.
     *
     * @static string
     */
    public static string $confirm = 'Are you sure you wish to continue?';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $id = $this->argument('userId');

        $role = strtolower(trim($this->argument('role')));

        // find user
        try {
            $user = config('backend.user')::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->error('User not found.');

            return 1;
        }

        // confirm super admin
        if ($role === config('backend.super_admin_role') && !$this->option('force')) {
            $this->warn(' You\'re about to create a super admin. This grants all roles and permissions, including the ability to create other super admins.');
            
            if (!$this->confirm('Are you sure you wish to continue?')) {
                $this->error('Action aborted, no roles were granted.');

                return 1;
            }
        }

        // grant role to user
        DB::transaction(function () use ($user, $role) {
            $role = Role::firstOrCreate(['name' => $role]);

            $user->assignRole($role);
        });

        $this->info('Successfully assigned role to user.');

        return 0;
    }
}
