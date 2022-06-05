<?php

namespace Bedard\Backend\Console;

use App\Models\User;
use Backend;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizeCommand extends Command
{
    /**
     * Console output.
     *
     * @var arr
     */
    public static $messages = [
        'canceled' => "Authorization canceled.",
        'complete' => "Authorization complete!",
        'confirmSuperAdmin' => "Are you sure you want to authorize a new super admin?\n <fg=default>This grants all permissions, including the ability to create other super admins.",
        'invalidOptions' => "Invalid arguments, please specify --permission, --role, or --super.",
        'userNotFound' => "User not found.",
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:authorize
            {userId}
            {--role= : Role name}
            {--permission= : Permission code}
            {--super : Create super-admin, with full access to everything}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant backend permissions to a user';

    /**
     * Authorize a user for a specific permission.
     *
     * @param \App\Models\User $user
     * @param string $permission
     *
     * @return int
     */
    private function authPermission(User $user, string $permission): int
    {
        Backend::authorize($user, $permission);

        $this->info(self::$messages['complete']);

        return 0;
    }

    private function authRole()
    {
        dd('not implemented');
    }

    /**
     * Authorize a super admin.
     *
     * @param \App\Models\User $user
     *
     * @return int
     */
    private function authSuper(User $user): int
    {
        if ($this->confirm(self::$messages['confirmSuperAdmin'])) {
            return $this->authPermission($user, 'super admin');
        }

        $this->info(self::$messages['canceled']);

        return 0;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // fetch the user
        $id = $this->argument('userId');

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->error(self::$messages['userNotFound']);

            return 1;
        }

        if (!$this->valid()) {
            $this->error(self::$messages['invalidOptions']);

            return 1;
        }

        if ($this->super()) {
            return $this->authSuper($user);
        }

        elseif ($this->permission()) {
            return $this->authPermission($user, $this->option('permission'));
        }

        // elseif ($this->role()) {
        //     return $this->authRole($user);
        // }

        dd('bad params');
    }

    /**
     * Test for the permission flag.
     *
     * @return bool
     */
    private function permission(): bool
    {
        return (bool) $this->option('permission');
    }

    /**
     * Test for the role flag.
     *
     * @return bool
     */
    private function role(): bool
    {
        return (bool) $this->option('role');
    }

    /**
     * Test for super flag or equivalent permission.
     *
     * @return bool
     */
    private function super(): bool
    {
        return $this->option('super') || strtolower($this->option('permission') || '') === 'super admin';
    }

    /**
     * Test if parameter combinations are valid.
     *
     * @return bool
     */
    private function valid(): bool
    {
        if ($this->super() && !$this->permission() && !$this->role()) {
            return true;
        }

        elseif ($this->permission() && !$this->role() && !$this->super()) {
            return true;
        }

        elseif ($this->role() && !$this->permission() && !$this->super()) {
            return true;
        }

        return false;
    }
}
