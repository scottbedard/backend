<?php

namespace Bedard\Backend\Components;

class DateField extends Field
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Output
     */
    protected function output()
    {
        return fn ($model) => view('backend::renderables.date-field', [
            'id' => $this->id,
            'model' => $model,
            'date' => 'hello world',
        ]);   
    }
}
