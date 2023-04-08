<?php

namespace Bedard\Backend\Plugins;

use Bedard\Backend\Classes\Paginator;
use Bedard\Backend\Classes\Plugin;
use Bedard\Backend\Exceptions\PluginValidationException;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Arr;
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
        data_fill($config, 'options.schema', []);
        data_fill($config, 'options.toolbar', []);

        if (Arr::isAssoc($config['options']['schema'])) {
            $cols = [];

            foreach ($config['options']['schema'] as $id => $col) {
                $cols[] = array_merge(['id' => $id], $col);
            }

            data_set($config, 'options.schema', $cols);
        }

        foreach ($config['options']['actions'] as $key => $action) {
            data_fill($config, "options.actions.{$key}.theme", 'default');
        }

        foreach ($config['options']['schema'] as $key => $col) {
            data_fill($config, "options.schema.{$key}.type", 'text');
            data_fill($config, "options.schema.{$key}.label", Str::headline($col['id']));
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
            // actions
            'options.actions' => ['required', 'array'],
            'options.actions.*.icon' => ['string'],
            'options.actions.*.label' => ['required', 'string'],
            'options.actions.*.to' => ['string'],

            // checkboxes
            'options.checkboxes' => ['required', 'boolean'],

            // schema
            'options.schema' => ['required', 'array'],
            'options.schema.*.type' => ['required', 'string'],
        ]);
        
        if ($validator->fails()) {
            throw new PluginValidationException('Invalid list config: ' . $validator->errors()->first());
        }
    }
}
