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
        $parent = $this->climb(fn ($p) => array_key_exists('permissions', $p->__config));
    
        if (!$parent) {
            return $permissions;
        }

        return array_unique(array_merge($parent->__config['permissions'], $permissions));
    }
}