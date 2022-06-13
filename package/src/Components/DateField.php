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
    ];

    /**
     * Output
     */
    protected function output()
    {
        return fn ($model) => view('backend::renderables.date-field', [
            'id' => $this->id,
            'model' => $model,
            'parse' => $this->parse,
            'value' => $model->{$this->id},
        ]);   
    }
}
