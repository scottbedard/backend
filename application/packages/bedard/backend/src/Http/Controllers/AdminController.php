<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Manage roles and permissions
     *
     * @param \Illuminate\Http\Request $request
     */
    public function permissions()
    {
        return view('backend::admin', [
            // ...
        ]);
    }
}
