<?php

namespace Bedard\Backend\Columns;

use Bedard\Backend\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CarbonColumn extends Column
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
     * @return string
     */
    public function render(Model $model)
    {
        $carbon = Carbon::createFromFormat($this->parse, $model->{$this->key});

        return $this->diffForHumans
            ? $carbon->diffForHumans()
            : $carbon->format($this->format);
    }
}
