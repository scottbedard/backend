<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class BladeField extends ColumnType
{
    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View
     */
    public function render(Model $model): View
    {
        return view($this->__parent->view, [
            'model' => $model,
        ]);
    }
}
