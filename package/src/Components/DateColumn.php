<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DateColumn extends Column
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'diffForHumans' => false,
        'format' => 'M jS, Y',
        'parse' => 'Y-m-d H:i:s',
    ];

    /**
     * Render
     *
     * @return \Illuminate\View\View|string|callable
     */
    protected function output()
    {
        return function (Model $row) {
            $value = $row->{$this->id};

            if (!$value) {
                return '';
            }

            $carbon = Carbon::createFromFormat($this->parse, $row->{$this->id});

            return $this->diffForHumans
                ? $carbon->diffForHumans()
                : $carbon->format($this->format);
        };
    }
}
