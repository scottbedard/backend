<?php

namespace Bedard\Backend\Classes;

use Bedard\Backend\Classes\UrlPath;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Router
{
    /**
     * Router configuration
     *
     * @var $config
     */
    protected array $config;

    /**
     * Create a new router
     *
     * @param \Illuminate\Contracts\Support\Arrayable $config
     *
     * @return \Bedard\Backend\BackendController
     */
    public function __construct(Arrayable|array $config = [])
    {
        $this->config = (array) $config;
    }

    /**
     * Parse a request string
     *
     * @param string $str
     *
     * @return array
     */
    public function parse(string $str): array
    {
        $url = Str::of($str)
            ->trim('/')
            ->ltrim(config('backend.path'))
            ->ltrim('/')
            ->toString();
        
        $path = parse_url($url, PHP_URL_PATH);

        $fragment = parse_url($url, PHP_URL_FRAGMENT);

        $query = [];

        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        return [
            'fragment' => $fragment,
            'path' => $path,
            'query' => $query,
        ];
    }

    /**
     * Resolve a controller method from path
     *
     * @param string $path
     *
     * @return mixed
     */
    public function resolve(string $rawPath)
    {
        // parse the url
        $url = $this->parse($rawPath);  
        
        $segments = Str::of(data_get($url, 'path'))
            ->lower()
            ->explode('/')
            ->map(fn ($str) => trim($str));

        
        // find routes for the controller
        $controllerName = $segments->first();
        $controllerRoutes = data_get($this->config, $controllerName . '.routes', []);

        // if there are no routes, return null
        if (empty($controllerRoutes)) {
            return null;
        }

        // match the index path of "/"
        $currentRoute = (new UrlPath(data_get($url, 'path')))->segments->slice(1);

        if ($currentRoute->isEmpty()) {
            foreach ($controllerRoutes as $method => $config) {
                if (data_get($config, 'path') === '/') {
                    return [$controllerName, $method];
                }
            }

            return null;

            dd([
                'rawPath' => $rawPath,
                'currentRoute' => $currentRoute,
                'segments' => $segments,
                'controllerName' => $controllerName,
                'controllerRoutes' => $controllerRoutes,
            ]);
        }


        // $routes = data_get($this->config, $controller . '.routes', []);

        // if (empty($routes)) {
        //     return null;
        // }

        // match an index path
        // $fullPath = new UrlPath(data_get($url, 'path'));

        // $currentRoute = $fullPath->segments->slice(1);

        // if ($currentRoute->isEmpty()) {
        //     foreach ($routes as $method => $config) {
        //         if (data_get($config, 'path') === '/') {
        //             return $controller . '.routes.' . $method;
        //         }
        //     }
            
        //     return null;
        // }

        // // route to a method
        // foreach ($routes as $method => $config) {
        //     if (data_get($config, 'path') === '/') {
        //         continue;
        //     }
            

        // }
        
        return [];
    }
}