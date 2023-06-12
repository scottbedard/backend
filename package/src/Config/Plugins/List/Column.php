<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Column extends Config
{
    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'label' => ['present', 'nullable', 'string'],
            'id' => ['required', 'nullable', 'string'],
            'type' => ['present', 'nullable', 'string', 'in:blade,date,text,timeago'],
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
     * Set columns
     *
     * @return \Bedard\Backend\Config\Plugins\List\ColumnType
     */
    public function setTypeAttribute(): ColumnType
    {
        $columns = config('backend.columns');

        $type = data_get($this->__config, 'type');

        if (!is_string($type)) {
            return TextColumn::create($this->__config, $this, 'type');
        }

        if (class_exists($type)) {
            return $type::create($this->__config, $this, 'type');
        }

        foreach ($columns as $alias => $class) {
            if (trim(strtolower($type)) === trim(strtolower($alias))) {
                return $class::create($this->__config, $this, 'type');
            }
        }

        $path = $this->getConfigPath();

        throw new ConfigException("{$path}: Invalid column type [{$type}]");
    }
}
