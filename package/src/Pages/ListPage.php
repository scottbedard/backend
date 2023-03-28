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
        $controllers = $data['controllers'];
        $route = $data['route'];
        
        // ...

        return [];
    }
}
