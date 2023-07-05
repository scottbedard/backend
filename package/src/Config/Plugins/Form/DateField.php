<?php

namespace Bedard\Backend\Config\Plugins\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class DateField extends FieldType
{
    /**
     * Define validation rules
     *
     * @return array
     */
    public function defineValidation(): array
    {
        return [
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
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ];
    }

    /**
     * Render
     *
     * @param  Model  $model
     *
     * @return Illuminate\View\View
     */
    public function render(Model $model = null): View
    {
        return view('backend::form.date-field', [
            'field' => $this,
            'value' => $this->value($model),
        ]);
    }
}
