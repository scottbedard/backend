<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Exceptions\InvalidFieldSpan;
use Illuminate\Support\Facades\Validator;

class Field extends Fluent
{
    /**
     * All of the attributes set on the fluent instance
     *
     * @var array
     */
    protected $attributes = [
        'id' => '',
        'label' => '',
        'required' => false,
        'span' => [
            'sm' => null,
            'md' => null,
            'lg' => null,
            'xl' => null,
            '2xl' => null,
        ],
        'value' => null,
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'input' => \Bedard\Backend\Fields\InputField::class
    ];

    /**
     * Init
     *
     * @param string $key
     *
     * @return void
     */
    public function init(string $id = '')
    {
        $this->attributes['id'] = $id;
    }

    /**
     * Set span
     *
     * @param array $span
     *
     * @throws \Bedard\Backend\Exceptions\InvalidFieldSpan
     *
     * @return void
     */
    public function setSpanAttribute(array $span)
    {
        $rules = ['nullable', 'integer', 'gte:0', 'lte:12'];

        $validator = Validator::make($span, [
            'sm' => $rules,
            'md' => $rules,
            'lg' => $rules,
            'xl' => $rules,
            '2xl' => $rules,
        ], [
            'gte' => "The \":attribute\" span for field \"{$this->id}\" must be an greater than or equal to 1.",
            'integer' => "The \":attribute\" span for field \"{$this->id}\" must be an integer.",
            'lte' => "The \":attribute\" span for field \"{$this->id}\" must be an less than or equal to 12.",
        ]);

        if ($validator->fails()) {
            throw new InvalidFieldSpan($validator->errors()->first());
        }

        $this->attributes['span'] = array_merge($this->attributes['span'], $span);
    }
}