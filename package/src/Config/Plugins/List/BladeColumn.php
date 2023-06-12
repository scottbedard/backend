<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BladeColumn extends ColumnType
{
    /**
     * Render
     * 
     * @param Model $model
     *
     * @return Illuminate\View\View|string
     */
    public function render(Model $model): View|string
    {
        return view($this->__parent->view, [
            'model' => $model,
        ]);
    }
}