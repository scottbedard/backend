<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Classes\Page;
use Bedard\Backend\Facades\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Backend single page application.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($request);

        return Backend::view([
            // ...
        ]);
    }
}
