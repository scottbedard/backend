<?php

namespace Tests\Unit\Traits;

trait DynamicTrait
{
    public function getDefaultTestConfig()
    {
        return 'hello';
    }

    public function getDefaultOverwriteConfig()
    {
        return 'default value';
    }

    public function getDefaultMultiWordConfig()
    {
        return 'world';
    }
}