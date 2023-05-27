<?php

namespace Tests\Unit\Traits;

trait DynamicTestAttribute
{
    public function getDefaultTestAttribute()
    {
        return 'hello';
    }

    public function getDefaultOverwriteAttribute()
    {
        return 'default value';
    }

    public function getDefaultMultiWordAttribute()
    {
        return 'world';
    }
}