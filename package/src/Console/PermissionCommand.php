<?php

namespace Bedard\Backend\Console;

use Backend;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:permission
            {user}
            {--area= : Backend area. For resources, this is the full namespace and class name}
            {--code= : Permission code (create, read, update, delete, etc...)}
            {--super : Create super-user, with full access to everything}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create backend permission to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // fetch the user
        $id = $this->argument('user');

        try {
            $user = Backend::userQuery()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->error('User not found');

            return 1;
        }

        // normalize options
        $area = BackendPermission::normalizeArea($this->option('area') ?? '');
        $code = BackendPermission::normalizeCode($this->option('code') ?? 'super');

        // grant super admin
        if ($this->super($area, $code)) {
            if ($this->confirm("Are you sure you want to create a new super admin?\n <fg=default>This grants all permissions, including the ability to create other super admins")) {
                BackendPermission::grant($user->id, 'all', 'super');

                $this->info('Super admin created!');

                return 0;
            }

            $this->error('Super admin canceled.');

            return 1;
        }

        // grant permission
        if (!$area) {
            $this->error('No backend area specified.');

            return 1;
        }

        BackendPermission::grant($user->id, $area, $code);

        $this->info('Backend permission created!');

        return 0;
    }

    /**
     * Test if a super admin is being created.
     *
     * @param string $area
     * @param string $code
     *
     * @return bool
     */
    private function super(string $area, string $code): bool
    {
        if ($this->option('super')) {
            return true;
        }

        if ($area === 'all' && $code === 'super') {
            return true;
        }

        return false;
    }
}