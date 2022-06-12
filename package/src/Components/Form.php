<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Block;

class Form extends Block
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
     * Providable
     *
     * @var array
     */
    protected $providable = [
        'fields',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('backend::renderables.form', [
            'action' => $this->action ?: $this->data['action'],
            'context' => $this->data['context'],
            'fields' => $this->fields,
            'model' => $this->data['model'],
            'resource' => $this->data['resource'],
        ]);
    }
}
