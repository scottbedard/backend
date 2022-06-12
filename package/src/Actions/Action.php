<?php

namespace Bedard\Backend\Actions;

use App\Models\User;
use Backend;
use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Exceptions\UnauthorizedActionException;
use Bedard\Backend\Resource;

class Action extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'resource' => null,
        'permission' => '',
    ];

    /**
     * Handle
     *
     * @return void
     */
    protected function handle($resource, $user, $data = [])
    {
        return [];
    }

    /**
     * Run
     *
     * @return void
     */
    public function run(Resource $resource, User $user, $data = [])
    {
        if (Backend::check($user, $this->permission)) {
            dd($this->permission);
            return $this->handle($resource, $user, $data);
        }

        throw new UnauthorizedActionException("Unauthorized");
    }
}
