<?php

namespace Bedard\Backend\Config\Plugins;

use Bedard\Backend\Config\Plugins\Form\Field;
use Illuminate\Http\Request;

class FormPlugin extends Plugin
{
    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [
            'fields' => [Field::class, 'id'],
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
            'fields' => ['present', 'array'],
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
            'fields' => [],
        ];
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
        return view('backend::form', [
            'fields' => $this->fields,
        ]);
    }
}
