<?php

namespace Bedard\Backend\Console;

use Backend;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeauthorizeCommand extends Command
{
    /**
     * Confirmation message.
     *
     * @var string
     */
    public static $confirmation = "Are you sure you want to deauthorize this user?\n <fg=default>This fully revokes all backend permissions.";


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:deauthorize
            {user}
            {--area= : Backend area}
            {--code= : Permission code}
            {--super : Revoke all permissions, blocking access to everything}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke backend permissions from a user';

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

        // deauthorize super admin
        if ($this->super($area, $code)) {
            if ($this->confirm(self::$confirmation)) {
                Backend::deauthorize($user, 'all', 'all');

                $this->info('Deauthorization complete!');

                return 0;
            }

            $this->error('Deauthorization canceled.');

            return 1;
        }

        // permission area
        if (!$area) {
            $this->error('No backend area specified.');

            return 1;
        }

        Backend::deauthorize($user, $area, $code);

        $this->info('Deauthorization complete!');

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
