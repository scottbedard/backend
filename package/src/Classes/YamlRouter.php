<?php

namespace Bedard\Backend\Classes;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Yaml\Yaml;

class YamlRouter
{
    /**
     * Core backend controller
     *
     * @return array
     */
    public static function core(): array
    {
        return Yaml::parseFile(realpath(__DIR__ . '/../backend.yaml'));
    }

    /**
     * 
     */
    public static function controllers(): array
    {
        $core = self::core();

        self::validate('Core controller', $core);
        


        return [];
    }

    /**
     * Validate a controller yaml file
     *
     * @param string $prefix
     * @param array $data
     */
    public static function validate(string $prefix, array $data)
    {
        try {
            Validator::make($data, [
                '*.path' => 'distinct:ignore_case|required',
            ])->validate();
        } catch (ValidationException $e) {
            throw new Exception($prefix . ': ' . $e->getMessage());
        }
    }
}