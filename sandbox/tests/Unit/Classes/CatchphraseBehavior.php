<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class CatchphraseBehavior extends Behavior
{
    public function getCatchphraseAttribute()
    {
        return 'Wubba-lubba-dub-dub!';
    }
}