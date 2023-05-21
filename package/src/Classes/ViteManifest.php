<?php

namespace Bedard\Backend\Classes;

use Exception;
use Illuminate\Support\Facades\File;

class ViteManifest
{
    /**
     * Parsed manifest data
     *
     * @param array
     */
    protected array $data;

    /**
     * Raw manifest json
     *
     * @var string
     */
    protected string $json;

    /**
     * Create a new manifest instance
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->json = File::exists($path) ? File::get($path) : '{}';

        $this->data = json_decode($this->json, true);
    }

    /**
     * Get a script by name
     *
     * @param string $name
     *
     * @return string
     */
    public function script(string $name)
    {
        foreach ($this->data as $entry => $data) {
            if ($entry !== $name) {
                continue;
            }

            if (
                array_key_exists('file', $data) &&
                array_key_exists('isEntry', $data) &&
                $data['isEntry']
            ) {
                return $data['file'];
            }
        }

        throw new Exception('Vite script not found: ' . $name);
    }

    /**
     * Scripts
     *
     * @return array
     */
    public function scripts(): array
    {
        $arr = [];

        foreach ($this->data as $entry => $data) {
            if (
                array_key_exists('file', $data) &&
                array_key_exists('isEntry', $data) &&
                $data['isEntry']
            ) {
                array_push($arr, $data['file']);
            }
        }

        return $arr;
    }

    /**
     * Styles
     *
     * @return array
     */
    public function styles(): array
    {
        $arr = [];

        foreach ($this->data as $entry => $data) {
            if (
                str_ends_with($entry, '.css') &&
                array_key_exists('file', $data)
            ) {
                array_push($arr, $data['file']);
            }
        }

        return $arr;
    }
}