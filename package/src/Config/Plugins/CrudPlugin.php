<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Behaviors\Permissions;
use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;

class CrudPlugin extends Plugin
{
    /**
     * Form plugin
     *
     * @var \Bedard\Backend\Config\Plugins\FormPlugin
     */
    protected FormPlugin $form;

    /**
     * List plugin
     *
     * @var \Bedard\Backend\Config\Plugins\ListPlugin
     */
    protected ListPlugin $list;

    /**
     * Create plugin instance
     *
     * @param  array  $config
     * @param  Config  $parent
     * @param  ?string  $configPath
     */
    public function __construct(array $config = [], Config $parent = null, string $configPath = null)
    {
        if (!array_key_exists('permissions', $config)) {
            $config['permissions'] = str($parent->id)->plural()->toString() . '.read';
        }

        parent::__construct($config, $parent, $configPath . '.crud');
    }

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
     * Default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'checkboxes' => false,
            'columns' => [],
            'fields' => [],
            'models' => [],
            'row_to' => null,
        ];
    }

    /**
     * Form
     *
     * @return \Bedard\Backend\Config\Plugins\FormPlugin
     */
    public function form()
    {
        $props = [
            'fields' => $this->fields,
        ];

        $form = FormPlugin::create($props, $this);

        $form->validate();

        return $form;
    }

    /**
     * List
     *
     * @return \Bedard\Backend\Config\Plugins\ListPlugin
     */
    public function list()
    {
        $props = [
            'checkboxes' => $this->checkboxes,
            'columns' => $this->columns,
            'models' => $this->models,
            'row_to' => $this->row_to ?: ':backend/:controller/:route/edit/{id}',
        ];

        $list = ListPlugin::create($props, $this);

        $list->validate();

        return $list;
    }

    /**
     * Render
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|array
     */
    public function handle(Request $request)
    {
        $path = str(
            str($request->extra)
                ->lower()
                ->explode('/')
                ->map(fn ($seg) => trim($seg))
                ->implode('/')
        );

        if ($path->toString() === '') {
            return $this->list()->handle($request);
        }

        if ($path->is('create')) {
            throw new \Exception('create');
        }

        if ($path->is('edit/*')) {
            return $this->form()->handle($request);
        }

        throw new \Exception('404');
    }
}
