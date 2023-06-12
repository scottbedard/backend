<?php

namespace Bedard\Backend\Config\Plugins\List;

use Bedard\Backend\Config\Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DateColumn extends ColumnType
{
    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
            'diff_for_humans' => ['present', 'boolean'],
            'format' => ['required', 'string'],
        ];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'diff_for_humans' => false,
            'format' => 'M jS Y',
        ];
    }

    /**
     * Render
     * 
     * @param Model $model
     *
     * @return Illuminate\View\View|string
     */
    public function render(Model $model): View|string
    {
        $c = Carbon::parse($model->{$this->__parent->id});

        return $this->diff_for_humans
            ? $c->diffForHumans()
            : $c->format($this->format);
    }
}
