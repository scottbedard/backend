<?php

namespace Bedard\Backend\Components;

class DateField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'parse' => 'yyyy-MM-dd HH:mm:ss',
        'format' => 'MMMM do, yyyy',
    ];

    /**
     * Output
     */
    protected function output()
    {
        return fn ($model) => view('backend::renderables.date-field', [
            'format' => $this->format,
            'id' => $this->id,
            'label' => $this->label,
            'parse' => $this->parse,
            'required' => $this->required,
            'value' => $model->{$this->id},
        ]);   
    }
}
