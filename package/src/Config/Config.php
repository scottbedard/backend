<?php

namespace Bedard\Backend\Config;

use ArrayAccess;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class Config implements ArrayAccess, Arrayable
{
    /**
     * Raw yaml config
     *
     * @var array
     */
    public readonly array $__config;

    /**
     * Normalized config data
     *
     * @var array
     */
    public readonly array $__data;

    /**
     * Parent config instance
     *
     * @var ?self
     */
    public readonly ?self $__parent;

    /**
     * Validation rules
     *
     * @var array
     */
    public readonly array $__rules;

    /**
     * Create config instance
     *
     * @param array $__config
     */
    public function __construct(array $config = [], self $parent = null)
    {
        // set default attributes and parent instance
        $this->__parent = $parent;

        $methods = get_class_methods($this);

        $defaults = $this->getDefaultConfig();

        $inherited = $this->getInheritedConfig();

        foreach ($methods as $method) {
            if (str($method)->is('getDefault*Attribute')) {
                $attr = str(substr($method, 10, -9))->snake()->toString();

                data_fill($defaults, $attr, $this->$method());
            }
        }

        foreach ($inherited as $key) {
            $parent = $this->climb(fn ($p) => array_key_exists($key, $p->__config));

            if ($parent) {
                data_fill($config, $key, $parent->__config[$key]);
            }
        }

        $this->__config = array_merge($defaults, $config);

        // iterate over config and create child instances
        $data = [];

        $children = $this->getChildren();
        
        foreach ($this->__config as $configKey => $configValue) {

            // prefer custom setters over all else
            $setter = str('set_' . $configKey . '_attribute')->camel()->toString();

            if (method_exists($this, $setter)) {
                $data[$configKey] = $this->$setter($configValue);
            }

            // otherwise convert array into collections
            elseif (array_key_exists($configKey, $children)) {
                $child = $children[$configKey];

                // map strings directly to their class names
                if (is_string($child)) {
                    $data[$configKey] = $child::create($configValue, $this);
                }

                // map single-entry arrays to their class name
                elseif (is_array($child) && count($child) === 1) {
                    [$childClass] = $child;

                    $data[$configKey] = collect($configValue)->map(fn ($m) => $childClass::create($m, $this));
                }

                // map dual-entry arrays to their class name and keyed property
                elseif (is_array($child) && count($child) === 2) {
                    [$childClass, $childKey] = $child;

                    $data[$configKey] = collect(KeyedArray::from($configValue, $childKey))
                        ->map(fn ($child) => $childClass::create($child, $this))
                        ->sortBy('order')
                        ->values();
                }
            }

            // finally, set all other static data
            else {
                $data[$configKey] = $configValue;
            }
        }
        
        $this->__data = $data;

        // collect all validation rules
        $rules = $this->getValidationRules();

        foreach (array_filter($methods, fn ($m) => $m !== 'getValidationRules') as $method) {
            if (str($method)->is('get*ValidationRules')) {
                $rules = array_merge($rules, $this->$method());
            }
        }

        foreach ($rules as $key => $value) {
            if (is_null($value)) {
                unset($rules[$key]);
            }
        }

        $this->__rules = $rules;
    }

    /**
     * Get a piece of data
     *
     * 
     */
    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    /**
     * Find ancestor
     *
     * @param callable $fn
     *
     * @return ?self
     */
    public function climb(callable $fn): ?self
    {
        $parent = $this->__parent;

        if ($parent) {
            return $fn($parent) ? $parent : $parent->climb($fn);
        }

        return null;
    }

    /**
     * Find closest ancestor
     *
     * @return ?self
     */
    public function closest(string $class): ?self
    {
        return $this->climb(fn ($parent) => get_class($parent) === $class);
    }

    /**
     * Static constructor
     *
     * @param mixed ...$args
     *
     * @return static
     */
    public static function create(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Execute callback on descendents
     *
     * @param callable $fn
     *
     * @return void
     */
    public function descendents(callable $fn): void
    {
        $walk = function ($child) use ($fn) {
            if (is_a($child, self::class) || is_subclass_of($child, self::class)) {
                $fn($child);

                $child->descendents($fn); 
            }
        };

        foreach ($this->__data as $key => $val) {
            if (is_iterable($val)) {
                foreach ($this->$key as $child) {
                    $walk($child);
                }
            } else {
                $walk($this->$key);
            }
        }
    }

    /**
     * Get config value
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return data_get($this->__data, $key, $default);
    }

    /**
     * Get children definition
     *
     * @return array
     */
    public function getChildren(): array
    {
        return [];
    }

    /**
     * Get default config
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [];
    }

    /**
     * Get inherited config
     * 
     * @return array
     */
    public function getInheritedConfig(): array
    {
        return [];
    }

    /**
     * Check offset existence
     *
     * @param $offset
     */
    public function offsetExists($offset) {
        return isset($this->__data[$offset]);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [];
    }

    /**
     * Get data
     *
     * @param $offset
     */
    public function offsetGet($offset) {
        return isset($this->__data[$offset]) ? $this->__data[$offset] : null;
    }

    /**
     * Set data
     *
     * @param $offset
     * @param $value
     *
     * @throws \Bedard\Backend\Exceptions\ConfigurationArrayAccessException
     */
    public function offsetSet($offset, $value)
    {
        throw new ConfigurationArrayAccessException;
    }

    /**
     * Unset data
     *
     * @param $offset
     *
     * @throws \Bedard\Backend\Exceptions\ConfigurationArrayAccessException
     */
    public function offsetUnset($offset) {
        throw new ConfigurationArrayAccessException;
    }

    /**
     * Cast to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this->__data)->toArray();
    }

    /**
     * Validate config
     *
     * @throws \Bedard\Backend\Exceptions\ConfigurationException
     *
     * @return void
     */
    public function validate(): void
    {
        $validator = new Validator(
            translator: new Translator(new ArrayLoader, 'en'),
            data: $this->__config,
            rules: $this->__rules,
        );

        if ($validator->fails()) {
            throw new ConfigurationException('path.to.config: ' . $validator->errors()->first());
        }

        $this->descendents(fn ($child) => $child->validate());
    }
}