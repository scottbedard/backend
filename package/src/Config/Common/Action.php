<?php

namespace Bedard\Backend\Config\Common;

use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Bedard\Backend\Config\Common\Confirmation;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Config\Controller;
use Bedard\Backend\Config\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class Action extends Config
{
    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'confirmation' => Confirmation::class,
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
            'action' => 'present|nullable|string',
            'data' => 'present|array',
            'theme' => 'in:default,danger,primary,text',
            'type' => 'in:button,submit',
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
            'action' => null,
            'data' => [],
            'icon' => null,
            'label' => null,
            'secondary' => false,
            'theme' => 'default',
            'to' => null,
            'type' => 'button',
        ];
    }

    /**
     * Label
     *
     * @return string
     */
    public function label(array $data = []): string
    {
        $label = str($this->__data['label']);

        foreach ($data as $key => $value) {
            $label = $label->replace(":$key", $value);
        }
        
        return $label->toString();
    }

    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View
     */
    public function render(Model $model = null): View
    {
        $backend = $this->closest(Backend::class);
        $controller = $this->closest(Controller::class);
        $route = $this->closest(Route::class);

        $href = To::href(
            $this->to,
            $backend,
            $controller->id,
            $route->id,
            $model,
        );

        return view('backend::form.action', [
            'href' => $href,
            'icon' => $this->icon,
            'label' => $this->label,
            'type' => $this->type,
        ]);
    }
}
