<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Behaviors\Span;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigException;

class Field extends Config
{
    /**
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [
            Span::class,
        ];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'id' => null,
            'label' => null,
            'span' => 12,
            'type' => null,
        ];
    }

    /**
     * Set field type
     *
     * @return \Bedard\Backend\Config\Plugins\Form\FieldType
     */
    public function setTypeAttribute(): FieldType
    {
        $type = data_get($this->__config, 'type');

        if (!is_string($type)) {
            return TextField::create($this->__config, $this, 'type');
        }

        if (class_exists($type)) {
            return $type::create($this->__config, $this, 'type');
        }

        foreach (config('backend.fields') as $alias => $class) {
            if (trim(strtolower($type)) === trim(strtolower($alias))) {
                return $class::create($this->__config, $this, 'type');
            }
        }

        $path = $this->getConfigPath();

        throw new ConfigException("{$path}: Invalid field type [{$type}]");
    }
}