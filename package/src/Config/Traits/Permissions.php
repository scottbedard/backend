<?php

namespace Bedard\Backend\Config\Traits;

trait Permissions
{
    public function getDefaultPermissionsConfig(): array
    {
        return [];
    }

    public function setPermissionsConfig(array $permissions = [])
    {
        $parent = $this->climb(fn ($p) => is_array(data_get($p->__config, 'permissions')));
    
        if (!$parent) {
            return $permissions;
        }

        return array_unique(array_merge($parent->__config['permissions'], $permissions));
    }
}