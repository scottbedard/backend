<?php

namespace Bedard\Backend\Config;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Exceptions\ConfigurationException;

class Controller extends Config
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            Permissions::class,
        ];
    }

    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'nav' => [Nav::class],
        ];
    }

    /**
     * Set path attribute
     *
     * @param ?string $path
     *
     * @return ?string
     */
    public function setPathAttribute(?string $path): ?string
    {
        if (!array_key_exists('path', $this->__config)) {
            $id = $this->__config['id'];

            if (!is_string($id)) {
                throw new ConfigurationException($this->getConfigPath() . ': Invalid path');
            }

            if (str_starts_with($id, '_')) {
                return null;
            }

            return str($id)->slug()->toString();
        }

        return $this->__config['path'];
    }
}
