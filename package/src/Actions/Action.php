<?php

namespace Bedard\Backend\Actions;

use Bedard\Backend\Classes\Fluent;

class Action extends Fluent
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'id' => null,
        'permission' => null,
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
