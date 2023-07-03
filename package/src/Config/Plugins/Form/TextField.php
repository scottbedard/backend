<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Plugins\Form\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class TextField extends FieldType
{
    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View
     */
    public function render(?Model $model = null): View
    {
        return view('backend::form.text-field', [
            'field' => $this,
            'value' => $this->value($model),
        ]);
    }
}
