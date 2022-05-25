<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Backend single page application
     *
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function show(Request $request, string $id)
    {
        $resource = Backend::resource($id);

        $data = $resource->data();

        $schema = $resource->schema();

        return view('backend::resources-show', [
            'data' => $data,
            'schema' => $schema,
        ]);
    }
}
