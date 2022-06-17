<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;
use Bedard\Backend\Exceptions\InvalidGroupSpanException;
use Illuminate\Support\Facades\Validator;

class Group extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'between' => false,
        'block' => false,
        'class' => '',
        'el' => 'div',
        'gap' => false,
        'grid' => false,
        'padded' => false,
        'right' => false,
        'span' => [
            'sm' => null,
            'md' => null,
            'lg' => null,
            'xl' => null,
            '2xl' => null,
        ],
        'items' => [],
        'text' => '',
    ];

    /**
     * Output
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return view('backend::renderables.group', $this->attributes);
    }

    /**
     * Set span
     *
     * @param array $span
     *
     * @throws \Bedard\Backend\Exceptions\InvalidFieldSpan|number
     *
     * @return void
     */
    public function setSpanAttribute($span)
    {
        if (is_int($span)) {
            $this->attributes['span'] = [
                'sm' => null,
                'md' => null,
                'lg' => $span,
                'xl' => null,
                '2xl' => null,
            ];
        } else {
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
                throw new InvalidGroupSpanException($validator->errors()->first());
            }

            $this->attributes['span'] = array_merge($this->attributes['span'], $span);
        }
    }
}