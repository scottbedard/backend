<?php

namespace Bedard\Backend\Components;

class Form extends Group
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'action' => null,
        'fields' => [],
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    protected function output()
    {
        return view('backend::renderables.form', [
            'action' => $this->action ?: $this->data['action'],
            'context' => $this->data['context'],
            'fields' => $this->fields,
            'model' => $this->data['model'],
            'resource' => $this->data['resource'],
        ]);
    }
}
