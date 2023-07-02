<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Bedard\Backend\Config\Plugins\Form\Field;

class FieldType extends Config
{
    /**
     * Set field type
     *
     * @return string
     */
    public function setLabelAttribute($value)
    {
        if (is_string($value)) {
            return $value;
        }

        $id = data_get($this->__config, 'id', '');

        return str($id)->headline()->toString();
    }

    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View
     */
    public function render(?Model $model = null): View
    {
        return view('backend::form.unknown-field', [
            'id' => $this->id,
        ]);
    }
}
