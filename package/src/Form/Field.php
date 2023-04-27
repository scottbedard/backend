<?php

namespace Bedard\Backend\Form;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

abstract class Field
{
    /**
     * Field options
     *
     * @var array
     */
    protected array $options;

    /**
     * Validation rules
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * Create a field
     * 
     * @param array $options
     */
    public function __construct(array $options = []) {
        $this->options = $options;

        $this->validate();
    }

    /**
     * Get field options
     *
     * @param string $path
     * @param mixed $default
     */
    public function option(string $path, $default = null)
    {
        return data_get($this->options, $path, $default);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    abstract public function render(): View;

    /**
     * Validate config
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function validate(): void
    {
        $validator = Validator::make($this->options, $this->rules);
        
        if ($validator->fails()) {
            throw new Exception('Invalid form field: ' . $validator->errors()->first());
        }
    }
}