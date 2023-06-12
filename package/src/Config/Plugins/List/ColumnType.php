<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ColumnType extends Config
{
    /**
     * Render
     * 
     * @param Model $model
     *
     * @return Illuminate\View\View
     */
    public function render(Model $model): View
    {
        return view('backend::list.text-column', [
            'value' => $model->{$this->__parent->id},
        ]);
    }
}
