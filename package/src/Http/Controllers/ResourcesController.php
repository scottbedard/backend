<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourcesController extends Controller
{
    /**
     * Create
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function create(Request $request, string $id)
    {
        return 'Soon...';
    }

    /**
     * Show
     *
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function show(Request $request, string $id)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);
        
        if (!Backend::check($user, $resource::$area, 'read')) {
            return abort(401);
        }

        $table = $resource->table();

        return view('backend::resources-show', [
            'data' => $resource->data(),
            'columns' => $table->columns,
        ]);
    }
}
