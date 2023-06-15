<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @param array $config
     * @param Config $parent
     * @param ?string $configPath
     */
    public function __construct(array $config = [], Config $parent = null, string $configPath = null)
    {
        parent::__construct($config, $parent, $configPath . '.crud');
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
            'models' => [],
        ];
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
            $id = $path->after('edit/')->before('/');

            throw new \Exception("edit [$id]");
        }
        
        throw new \Exception('404');
    }
}
