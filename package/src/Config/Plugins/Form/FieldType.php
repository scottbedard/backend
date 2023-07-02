<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Bedard\Backend\Config\Plugins\Form\Field;

class FieldType extends Config
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
        return view('backend::form.unknown-field', [
            'id' => $this->id,
        ]);
    }
}
