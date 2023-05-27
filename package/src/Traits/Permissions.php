<?php

namespace Bedard\Backend\Traits;

use Bedard\Backend\Exceptions\ConfigurationException;

trait Permissions
{
    /**
     * Set permissions
     *
     * @return array
     */
    public function setPermissionsAttribute(?array $permissions): array
    {
        $permissions = is_array($permissions) ? $permissions : [];

        $this->climb(function ($ancestor) use (&$permissions) {
            $permissions = array_merge(data_get($ancestor->config, 'permissions', []), $permissions);
        });

        return array_unique($permissions);
    }

    /**
     * Test permissions for user
     *
     * @return void
     */
    public function testPermissionsForUser($user): void
    {

    }
}
