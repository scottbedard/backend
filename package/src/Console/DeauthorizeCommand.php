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
        'complete' => 'Authorization revoked!',
        'canceled' => 'Deauthorization canceled.',
        'confirmTotalDeauthorization' => "Are you sure you want to deauthorize this user?\n <fg=default>This fully revokes all backend permissions.",
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
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke backend permissions from a user';


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
            $user->permissions()->delete();
            $user->roles()->delete();

            $this->info('comlete');

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
}
