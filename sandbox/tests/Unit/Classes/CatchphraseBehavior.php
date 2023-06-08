<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;
use Bedard\Backend\Config\Config;

class CatchphraseBehavior extends Behavior
{
    public function getCatchphraseAttribute()
    {
        return 'Wubba-lubba-dub-dub!';
    }
}