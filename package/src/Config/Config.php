<?php

namespace Bedard\Backend\Config;

use ArrayAccess;
use BadMethodCallException;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class Config implements ArrayAccess, Arrayable
{
    /**
     * Behaviors
     *
     * @var \Illuminate\Support\Collection
     */
    public readonly Collection $__behaviors;

    /**
     * Normalized config
     *
     * @var array
     */
    public array $__config;

    /**
     * Config path to this instance
     *
     * @var ?string
     */
    public readonly ?string $__config_path;

    /**
     * Instanciated config data
     *
     * @var array
     */
    public array $__data;

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
     * @param array $config
     * @param ?self $parent
     * @param ?string $configPath
     */
    public function __construct(array $config = [], self $parent = null, string $configPath = null)
    {
        // store the raw config and set the relationship to our parent
        $this->__config_path = $configPath;
    
        $this->__parent = $parent;

        // instantiate behaviors
        $this->__behaviors = collect($this->defineBehaviors())->map(fn ($class) => new $class($this));

        // collect defaults and merge with the provided config
        $defaults = $this->getDefaultConfig();

        $methods = get_class_methods($this);

        foreach ($this->__behaviors as $behavior) {
            $methods = array_unique(array_merge($methods, get_class_methods($behavior)));
        }

        foreach ($methods as $method) {
            if ($method !== 'getDefaultConfig' && str($method)->is('getDefault*Config')) {
                $attr = str(substr($method, strlen('getDefault'), -strlen('Config')))->snake()->toString();
                if (method_exists($this, $method)) {
                    data_fill($defaults, $attr, $this->$method());
                } else {
                    foreach ($this->__behaviors as $behavior) {
                        if (method_exists($behavior, $method)) {
                            data_fill($defaults, $attr, $behavior->$method());

                            continue 2;
                        }
                    }
                }
            }
        }

        // normalized child arrays and store the original config
        $config = array_merge($defaults, $config);

        $original = $config;

        $children = $this->defineChildren();

        foreach ($children as $key => $definition) {
            if (!array_key_exists($key, $config) || !is_array($config[$key]) || !is_array($definition)) {
                continue;
            }

            if (count($definition) === 1 && Arr::isAssoc($config[$key])) {
                $config[$key] = [$config[$key]];
            }

            elseif (count($definition) === 2) {
                [, $childKey] = $children[$key];

                if (is_array($config[$key]) && is_string($childKey)) {
                    $config[$key] = collect(KeyedArray::from($config[$key], $childKey))
                        ->sortBy('order')
                        ->values()
                        ->toArray();
                }
            }
        }

        // inherit config from parent
        $inherited = $this->defineInherited();

        foreach ($inherited as $key) {
            $parent = $this->climb(fn ($p) => array_key_exists($key, $p->__config));

            if ($parent) {
                data_fill($config, $key, $parent->__config[$key]);
            }
        }

        // save the normalized config and begin creating child data
        $this->__config = $config;

        $data = [];
        
        foreach ($this->__config as $configKey => $configValue) {

            // prefer custom setters over all else
            $setter = str('set_' . $configKey . '_attribute')->camel()->toString();

            if (in_array($setter, $methods)) {
                if (method_exists($this, $setter)) {
                    $data[$configKey] = $this->$setter($configValue);
                } else {
                    foreach ($this->__behaviors as $behavior) {
                        if (method_exists($behavior, $setter)) {
                            $data[$configKey] = $behavior->$setter($configValue);

                            break;
                        }
                    }
                }
            }

            // when no setter is present, begin instantiating children
            elseif (array_key_exists($configKey, $children)) {
                $child = $children[$configKey];

                // string values represents a direct child
                if (is_string($child)) {
                    $data[$configKey] = $child::create($configValue, $this, $configKey);
                }
                
                // arrays represent a "has many" style relationship
                elseif (is_array($child)) {
                    [$childClass] = $child;

                    $data[$configKey] = collect($configValue)
                        ->map(function ($item, $i) use ($child, $childClass, $configKey, $original) {
                            
                            // simplify config path when using the "only child" syntax
                            if (count($child) === 1 && Arr::isAssoc($original[$configKey])) {
                                return $childClass::create($item, $this, $configKey);
                            }

                            // otherwise append the index or key
                            $childKey = count($child) === 2 ? $item[$child[1]] : $i;

                            return $childClass::create($item, $this, "{$configKey}.{$childKey}");
                        });
                }
            }

            // finally, set all other static data
            else {
                $data[$configKey] = $configValue;
            }
        }
        
        $this->__data = $data;

        // collect validation rules
        $rules = $this->getValidationRules();

        foreach ($methods as $method) {
            if ($method !== 'getValidationRules' && str($method)->is('get*ValidationRules')) {
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
     * Call a method
     * 
     * @param string $name
     * @param array $arguments
     * 
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        foreach ($this->__behaviors as $behavior) {
            if (method_exists($behavior, $name)) {
                return $behavior->$name(...$arguments);
            }
        }

        throw new BadMethodCallException('Call to undefined method ' . get_class($this) . '::' . $name . '()');
    }

    /**
     * Get a piece of data
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if (str_starts_with($name, '__')) {
            return $this->$name;
        }

        $getter = str('get_' . $name . '_attribute')->camel()->toString();

        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        foreach ($this->__behaviors as $behavior) {
            if (method_exists($behavior, $getter)) {
                return $behavior->$getter();
            }
        }

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
     * Define behaviors
     *
     * @return array
     */
    public function defineBehaviors(): array
    {
        return [];
    }

    /**
     * Define child config
     *
     * @return array
     */
    public function defineChildren(): array
    {
        return [];
    }

    /**
     * Define inherited config
     * 
     * @return array
     */
    public function defineInherited(): array
    {
        return [];
    }

    /**
     * Execute callback on all descendents
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
     * Get full config path
     *
     * @return ?string
     */
    public function getFullConfigPath(): ?string
    {
        $path = $this->__config_path;

        $this->climb(function ($parent) use (&$path) {
            if ($parent->__config_path) {
                $path = $parent->__config_path . '.' . $path;
            }
        });
        
        return $path;
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
            $path = $this->getFullConfigPath() ?: 'Backend error';

            throw new ConfigurationException("{$path}: " . $validator->errors()->first());
        }

        $this->descendents(fn ($child) => $child->validate());
    }
}