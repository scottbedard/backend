<?php

namespace Bedard\Backend\Configuration;

use ArrayAccess;
use Bedard\Backend\Classes\KeyedArray;
use Bedard\Backend\Exceptions\ConfigurationArrayAccessException;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use ReflectionClass;

class Configuration implements ArrayAccess, Arrayable
{
    /**
     * Auto-create child instances
     *
     * @var bool
     */
    public static bool $autocreate = true;

    /**
     * Normalized yaml data
     *
     * @var array
     */
    public array $config = [];

    /**
     * Configuration data
     *
     * @var array
     */
    public array $data = [];

    /**
     * Default data
     *
     * @var array
     */
    public static array $defaults = [];

    /**
     * Inherited data
     *
     * @var array
     */
    public array $inherits = [];

    /**
     * Parent
     *
     * @var self|null
     */
    public ?self $parent;

    /**
     * Parent key
     * 
     * @var ?string
     */
    public ?string $parentKey;

    /**
     * Child properties
     *
     * @var array
     */
    public array $props = [];

    /**
     * Construct
     *
     * @param array $yaml
     * @param ?self $parent
     * @param ?string $parentKey
     */
    public function __construct(array $yaml = [], ?self $parent = null, ?string $parentKey = null)
    {
        // inherit config and fill default values
        $config = $yaml;

        $this->parent = $parent;

        $this->parentKey = $parentKey;

        foreach ($this->inherits as $key) {
            $ancestor = $this->climb(fn ($p) => array_key_exists($key, $p->config));

            if ($ancestor) {
                data_fill($config, $key, $ancestor->config[$key]);
            }
        }

        foreach ($this->getDefaultValues() as $key => $value) {
            data_fill($config, $key, $value);
        }

        // normalize arrays
        foreach ($this->props as $key => $val) {
            if (!is_array($val)) {
                data_fill($config, $key, null);
            } else {
                data_fill($config, $key, []);

                if (count($val) === 1 && Arr::isAssoc($config[$key])) {
                    $config[$key] = [$config[$key]];
                } elseif (count($val) === 2) {
                    [$class, $id] = $val;

                    $config[$key] = collect(KeyedArray::from($config[$key], $id))
                        ->sortBy('order')
                        ->values()
                        ->toArray();
                }
            }
        }

        // validate and store the config. we're avoiding the validator facade because
        // facades require an application, which makes unit testing more difficult
        $validator = new Validator(
            translator: new Translator(new ArrayLoader, 'en'),
            data: $config,
            rules: $this->getValidationRules(),
        );

        if ($validator->fails()) {
            throw new ConfigurationException($this->getConfigurationPath() . ': ' . $validator->errors()->first());
        }

        $this->config = $config;

        // finalize data and instantiate child props
        $data = [];

        foreach ($this->config as $key => $val) {
            $prop = data_get($this->props, $key);

            $setter = str('set_' . $key . '_attribute')->camel()->toString();

            if (method_exists($this, $setter)) {
                $data[$key] = $this->$setter($val);
            } elseif (is_array($prop)) {
                $data[$key] = collect($config[$key])->map(fn ($item) => $prop[0]::$autocreate ? $prop[0]::create($item, $this, $key) : $item);
            } elseif ($prop && is_array($val)) {
                $data[$key] = $prop::$autocreate ? $prop::create($val, $this, $key) : $val;
            } else {
                $data[$key] = $val;
            }
        }

        // add parent keys to keyed array items
        foreach ($this->props as $key => $val) {
            if (is_array($val) && count($val) === 2 ) {
                [$class, $id] = $val;

                $data[$key]
                    ->filter(fn ($item) => is_a($item, $class))
                    ->each(fn ($item) => $item->parentKey = trim($item->parentKey . ".{$item->get($id)}", '.'));
            }
        }

        $this->data = $data;
    }

    /**
     * Find ancestor configuration
     *
     * @param callable $fn
     *
     * @return ?self
     */
    public function climb(callable $fn): ?self
    {
        $parent = $this->parent;

        if ($parent) {
            return $fn($parent) ? $parent : $parent->climb($fn);
        }

        return null;
    }

    /**
     * Find closest ancestor by type
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
     * @param $args
     *
     * @return self
     */
    public static function create(...$args): self
    {
        $config = get_called_class();
        
        return new $config(...$args);
    }

    /**
     * Get config data
     *
     * @param string $path
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        return data_get($this->data, $path, $default);
    }

    /**
     * Get configuration path
     *
     * @return string
     */
    public function getConfigurationPath(): string
    {
        $path = [];

        if ($this->parentKey) {
            array_push($path, $this->parentKey);
        }

        $this->climb(function ($parent) use (&$path) {
            $parentKey = $parent->parentKey;

            if ($parentKey) {
                array_push($path, $parentKey);
            }
        });

        return implode('.', array_reverse($path));
    }

    /**
     * Get default values
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        $defaults = [];

        $class = get_called_class();

        while ($class && is_array($class::$defaults)) {
            $defaults = array_merge($class::$defaults, $defaults);

            $class = get_parent_class($class);
        }

        return $defaults;
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
     * Check offset existence
     *
     * @param $offset
     */
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    /**
     * Get data
     *
     * @param $offset
     */
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * Set data
     *
     * @param $offset
     * @param $value
     *
     * @throws Bedard\Backend\Exceptions\ConfigurationArrayAccessException
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
     * @throws Bedard\Backend\Exceptions\ConfigurationArrayAccessException
     */
    public function offsetUnset($offset) {
        throw new ConfigurationArrayAccessException;
    }

    /**
     * Get the root ancestor
     *
     * @return self
     */
    public function root(): self
    {
        return $this->parent ? $this->parent->root() : $this;
    }

    /**
     * Cast to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this->data)->toArray();
    }
}
