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
    public function setPermissionsAttribute()
    {
        $permissions = data_get($this->config, 'permissions', []);

        $this->climb(function ($ancestor) use (&$permissions) {
            $permissions = array_merge(data_get($ancestor->config, 'permissions', []), $permissions);
        });

        return array_unique($permissions);
    }
}
