<?php

namespace Bedard\Backend\Console;

use Backend;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizeCommand extends Command
{
    /**
     * Confirmation message.
     *
     * @var string
     */
    public static $confirmation = "Are you sure you want to authorize a new super admin?\n <fg=default>This grants all permissions, including the ability to create other super admins.";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:authorize
            {user}
            {--area= : Backend area}
            {--code= : Permission code}
            {--super : Create super-admin, with full access to everything}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant backend permissions to a user';

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
            $user = config('backend.user')::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->error('User not found');

            return 1;
        }

        // normalize options
        $area = BackendPermission::normalize($this->option('area') ?? '');
        $code = BackendPermission::normalize($this->option('code') ?? 'all');

        // authorize super admin
        if ($this->super($area, $code)) {
            if ($this->confirm(self::$confirmation)) {
                Backend::authorize($user, 'all', 'all');

                $this->info('Authorization complete!');

                return 0;
            }

            $this->error('Authorization canceled.');

            return 1;
        }

        // permission area
        if (!$area) {
            $this->error('No backend area specified.');

            return 1;
        }

        Backend::authorize($user, $area, $code);

        $this->info('Authorization complete!');

        return 0;
    }

    /**
     * Test for super flag or options.
     *
     * @param string $area
     * @param string $code
     *
     * @return bool
     */
    private function super(string $area, string $code): bool
    {
        if ($area === 'all' && $code === 'all') {
            return true;
        }

        if ($this->option('super')) {
            return true;
        }

        return false;
    }
}