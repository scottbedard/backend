<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Index
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        return view('backend::index');
    }
}
