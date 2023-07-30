<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Behaviors\Span;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigException;
use Bedard\Backend\Rules\ColumnSpan;

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
            Permissions::class,
            Span::class,
        ];
    }

    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'label' => ['present', 'nullable', 'string'],
            'rules' => ['present'],
            'span' => ['required', new ColumnSpan],
            'type' => ['present', 'nullable', 'string'],
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
            'rules' => [],
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

        if (is_string($type)) {
            if (class_exists($type)) {
                return $type::create($this->__config, $this, 'type');
            }

            foreach (config('backend.fields') as $alias => $class) {
                if (trim(strtolower($type)) === trim(strtolower($alias))) {
                    return $class::create($this->__config, $this, 'type');
                }
            }
        }

        return TextField::create($this->__config, $this, 'type');
    }
}