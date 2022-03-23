<?php

namespace Bedard\Backend\Console;

trait StubParams
{
    /**
     * Replace the model property.
     *
     * @param string $stub
     * @param array $params
     *
     * @return $this
     */
    protected function replaceParams($stub, $params = [])
    {
        foreach ($params as $key => $value) {
            $stub = str_replace(
                ['{{' . $key . '}}', '{{ ' . $key . ' }}'], 
                [$value, $value], 
                $stub
            );
        }
        
        return $stub;
    }
}