<?php

namespace Bedard\Backend\Pages;

class ListPage
{
    /**
     * Fetch data for a page
     *
     * @param array $data
     *
     * @return array
     */
    public function data(array $data): array
    {
        $config = $data['config'];
        $controller = $data['controller'];
        $controllers = $data['controllers'];
        $route = $data['route'];
        
        $model = data_get($controllers, "{$controller}.model");

        if (!$model) {
            throw new Exception('No model registered to controller');
        }

        $data = $model::query()
            ->get();

        return [
            'data' => $data,
        ];
    }
}
