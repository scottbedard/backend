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
     * @return Illuminate\View\View|string
     */
    public function render(Model $model): View|string
    {
        return $model->{$this->__parent->id};
    }
}
