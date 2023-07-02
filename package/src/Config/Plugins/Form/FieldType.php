<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Bedard\Backend\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class FieldType extends Config
{
    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View|string
     */
    public function render(?Model $model = null): View|string
    {
        return 'field';
    }
}
