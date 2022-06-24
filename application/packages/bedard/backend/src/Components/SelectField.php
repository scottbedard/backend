<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Field;
use Illuminate\Http\Request;

class SelectField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'disabled' => false,
        'display' => 'id',
        'emptyMessage' => 'No results',
        'options' => [],
        'placeholder' => 'Select...',
        'readonly' => false,
        'required' => false,
        'searchable' => false,
        'searchPlaceholder' => 'Search',
    ];

    /**
     * Handler ID
     *
     * @var string
     */
    protected $handlerId = 'select-field';

    /**
     * Get search options.
     *
     * @return array
     */
    private function getOptions($search = null)
    {
        return is_callable($this->attributes['options'])
            ? $this->attributes['options']($search)
            : $this->attributes['options'];
    }

    /**
     * Component handler.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle(Request $request)
    {
        if ($request->id !== $this->id) {
            return;
        }

        return $this->getOptions($request->search);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return view('backend::renderables.select-field', array_merge($this->attributes, [
            'options' => $this->getOptions(),
            'handler' => route('backend.admin.handlers', ['id' => $this->handlerId]),
            'data' => $this->data,
        ]));
    }
}