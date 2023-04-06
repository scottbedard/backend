<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Exceptions\PluginValidationException;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListPlugin extends Plugin
{
    /**
     * Plugin data
     *
     * @return array
     */
    public function data(): array
    {
        $model = $this->controller['model'];

        $paginator = new Paginator($model::query()->paginate(20));

        return [
            'config' => $this->config,
            'data' => $paginator->data(),
        ];
    }

    /**
     * Normalize plugin config
     *
     * @param array $config
     *
     * @return array
     */
    protected function normalize(array $config): array
    {
        if (data_get($config, 'options') === null) {
            data_set($config, 'options', []);
        }

        data_fill($config, 'options.checkboxes', false);

        if (!is_array(data_get($config, 'options.schema'))) {
            data_set($config, 'options.schema', []);
        }

        foreach ($config['options']['schema'] as $key => $col) {
            data_fill($config, "options.schema.{$key}.type", 'text');
            data_fill($config, "options.schema.{$key}.label", Str::headline($key));
        }

        return $config;
    }

    /**
     * Render the plugin
     *
     * @return Illuminate\View\View
     */
    public function render(): View
    {
        $data = $this->data();

        return Backend::view(
            data: $data,
            view: 'backend::list', 
        );
    }

    /**
     * Validate config
     *
     * @throws \Bedard\Backend\Exceptions\PluginValidationException
     */
    public function validate(): void
    {
        $validator = Validator::make($this->config, [
            'options.checkboxes' => ['required', 'boolean'],
            'options.schema' => ['required', 'array'],
            'options.schema.*.type' => ['required', 'string'],
        ]);
        
        if ($validator->fails()) {
            throw new PluginValidationException('Invalid list config: ' . $validator->errors()->first());
        }
    }
}
