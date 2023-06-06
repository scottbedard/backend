<?php

namespace Bedard\Backend\Config\Behaviors;

use Bedard\Backend\Classes\Bouncer;
use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigException;

class Permissions extends Behavior
{
    /**
     * Construct
     *
     * @param Config $config
     * @param array $raw
     * @param string $for
     *
     * @return void
     */
    public function __construct(Config $config, array $raw)
    {
        parent::__construct($config, $raw);

        // reject if the user doesn't have access to this config
        $permissions = data_get($raw, 'permissions', []);
        
        if (!is_array($permissions) || array_sum(array_map('is_string', $permissions)) !== count($permissions)) {
            throw new ConfigException("{$config->getConfigPath()}: Permissions must be an array of strings");
        }

        if (!Bouncer::check(auth()->user(), $permissions)) {
            $this->reject();
        }
    }

    /**
     * Get default permissions
     *
     * @return array
     */
    public function getDefaultPermissions(): array
    {
        return [];
    }
}