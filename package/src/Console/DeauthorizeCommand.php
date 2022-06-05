<?php

namespace Bedard\Backend\Console;

use App\Models\User;
use Backend;
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
     * Console output.
     *
     * @var arr
     */
    public static $messages = [
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
            {user}
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
     * Remove all of a users permissions and roles.
     *
     * @param \App\Models\User $user
     *
     * @return int
     */
    private function authSuper(User $user): int
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
    }

    /**
     * Test if this is a total deauthorization
     */
    private function total()
    {
        return $this->option('permission') === null && $this->option('role') === null;
    }
}
