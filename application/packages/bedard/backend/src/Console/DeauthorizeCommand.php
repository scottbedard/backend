<?php

namespace Bedard\Backend\Console;

use App\Models\User;
use Backend;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeauthorizeCommand extends Command
{
    /**
     * Console output.
     *
     * @var arr
     */
    public static $messages = [
        'canceled' => 'Deauthorization canceled.',
        'complete' => 'Authorization revoked!',
        'confirmTotalDeauthorization' => "Are you sure you want to deauthorize this user?\n <fg=default>This fully revokes all backend permissions.",
        'invalidOptions' => "Invalid arguments, please specify --permission, --role, or --all.",
        'userNotFound' => "User not found.",
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        backend:deauthorize
            {userId}
            {--role= : Role name}
            {--permission= : Permission code}
            {--all : Revoke all permissions and roles}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke backend permissions from a user';

    /**
     * Test for all flag.
     *
     * @return bool
     */
    private function all(): bool
    {
        return (bool) $this->option('all');
    }

    /**
     * Authorize a user for a specific permission.
     *
     * @param \App\Models\User $user
     * @param string $name
     *
     * @return int
     */
    private function deauthorizePermission(User $user, string $name): int
    {
        Backend::deauthorize($user, $name);

        $this->info(self::$messages['complete']);

        return 0;
    }

    /**
     * Assign a user to a role.
     *
     * @param \App\Models\User $user
     * @param string $name
     *
     * @return int
     */
    private function deauthorizeRole(User $user, string $name): int
    {
        Backend::unassign($user, $name);

        $this->info(self::$messages['complete']);

        return 0;
    }

    /**
     * Remove all of a users permissions and roles.
     *
     * @param \App\Models\User $user
     *
     * @return int
     */
    private function deauthorizeTotal(User $user): int
    {
        if ($this->confirm(self::$messages['confirmTotalDeauthorization'])) {
            $user->roles()->get()->each(function ($role) use ($user) {
                $user->removeRole($role);
            });

            $user->permissions()->get()->each(function ($permission) use ($user) {
                $user->revokePermissionTo($permission);
            });

            $this->info(self::$messages['complete']);

            return 0;
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
        
        if ($this->total()) {
            return $this->deauthorizeTotal($user);
        }

        elseif ($this->permission()) {
            return $this->deauthorizePermission($user, $this->option('permission'));
        }

        elseif ($this->role()) {
            return $this->deauthorizeRole($user, $this->option('role'));
        }

        return 1;
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
     * Test if this is a total deauthorization
     */
    private function total()
    {
        return $this->option('permission') === null && $this->option('role') === null;
    }

    /**
     * Test if parameter combinations are valid.
     *
     * @return bool
     */
    private function valid(): bool
    {
        if ($this->all() && !$this->permission() && !$this->role()) {
            return true;
        }

        elseif ($this->permission() && !$this->role() && !$this->all()) {
            return true;
        }

        elseif ($this->role() && !$this->permission() && !$this->all()) {
            return true;
        }

        return false;
    }
}
