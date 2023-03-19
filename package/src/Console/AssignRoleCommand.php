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
     * Construct.
     *
     * @var string
     */
    public function __construct()
    {
        $this->description = trans('backend::console.authorize.description');

        $this->signature = '
            backend:assign-role {userId} {role}
                {--force : ' . trans('backend::console.authorize.force') . '}
        ';

        parent::__construct();
    }

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
            $this->error(trans('backend::console.authorize.user_not_found'));

            return 1;
        }

        // confirm super admin
        if ($role === 'backend.super-admin' && !$this->option('force')) {
            $this->warn(' ' . trans('backend::console.authorize.super_admin_info'));
            
            if (!$this->confirm(trans('backend::console.authorize.super_admin_confirm'))) {
                $this->error(trans('backend::console.authorize.abort'));

                return 1;
            }
        }

        // grant role to user
        DB::transaction(function () use ($user, $role) {
            $role = Role::firstOrCreate(['name' => $role]);

            $user->assignRole($role);
        });

        $this->info(trans('backend::console.authorize.success'));

        return 0;
    }
}
