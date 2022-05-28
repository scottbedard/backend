<?php

namespace Bedard\Backend\Columns;

use Bedard\Backend\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CarbonColumn extends Column
{
    /**
     * Difference for humans.
     *
     * @var bool
     */
    public bool $diffForHumans = false;

    /**
     * Format
     *
     * @var string
     */
    public string $format = 'M jS, Y';

    /**
     * Parse
     *
     * @var string
     */
    public string $parse = 'Y-m-d H:i:s';

    public function diffForHumans()
    {
        $this->diffForHumans = true;

        return $this;
    }

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
