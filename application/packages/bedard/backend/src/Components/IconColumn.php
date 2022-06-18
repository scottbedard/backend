<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Column;
use Illuminate\Database\Eloquent\Model;

class IconColumn extends Column
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'icon' => 'smile',
        'danger' => false,
        'primary' => false,
        'success' => false,
    ];

    /**
     * Render
     *
     * @return callable
     */
    protected function output(): callable
    {
        return function (Model $model) {
            $danger = $this->attributes['danger'];
            $icon = $this->attributes['icon'];
            $primary = $this->attributes['primary'];
            $success = $this->attributes['success'];

            return view('backend::renderables.icon-column', [
                'danger' => is_callable($danger) ? $danger($model) : $danger,
                'icon' => is_callable($icon) ? $icon($model) : $icon,
                'primary' => is_callable($primary) ? $primary($model) : $primary,
                'success' => is_callable($success) ? $success($model) : $success,
            ]);
        };
    }

    /**
     * Danger
     */
    public function setDangerAttribute($value)
    {
        $this->attributes['danger'] = $value;
    }

    /**
     * Primary
     */
    public function setPrimaryAttribute($value)
    {
        $this->attributes['primary'] = $value;
    }

    /**
     * Success
     */
    public function setSuccessAttribute($value)
    {
        $this->attributes['success'] = $value;
    }
}
