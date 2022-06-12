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
     * @param Bedard\Backend\Resource $resource
     * @param \App\Models\User $user
     * @param array $data
     *
     * @return mixed
     */
    public function handle($resource, $user, $data = [])
    {
        return [];
    }
}
