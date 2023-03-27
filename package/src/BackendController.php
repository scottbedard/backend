<?php

namespace Bedard\Backend;

class BackendController
{
    /**
     * Raw controller options
     *
     * @var array
     */
    protected array $options;

    /**
     * Create a new controller
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }
}
