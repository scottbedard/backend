<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Classes\Sort;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigException;

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
            'align' => ['required', 'string', 'in:left,right,center'],
            'id' => ['required', 'nullable', 'string'],
            'label' => ['present', 'nullable', 'string'],
            'sortable' => ['present', 'boolean'],
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
            'align' => 'left',
            'id' => null,
            'label' => null,
            'sortable' => false,
            'span' => 12,
            'type' => null,
        ];
    }

    /**
     * Sort href
     *
     * @return ?string
     */
    public function getSortHrefAttribute(): ?string
    {
        if (!$this->sortable) {
            return null;
        }

        $req = request();

        if ($this->sort->column !== $this->id || $this->sort->direction === 0) {
            return urldecode($req->fullUrlWithQuery(['sort' => "{$this->id},asc"]));
        }

        if ($this->sort->direction === 1) {
            return urldecode($req->fullUrlWithQuery(['sort' => "{$this->id},desc"]));
        }

        if ($this->sort->direction === -1) {
            $url = $req->fullUrlWithQuery(['sort' => null]);

            return $url === $req->url() . '?' ? $req->url() : $url;
        }

        return null;
    }

    /**
     * Sort
     *
     * @return \Bedard\Backend\Classes\Sort
     */
    public function getSortAttribute(): Sort
    {
        return Sort::create(request()->fullUrl(), $this->id);
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
