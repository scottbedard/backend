<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Components\ResourceIndex;
use Bedard\Backend\Http\Controllers\Controller;

class DebugController extends Controller
{
    /**
     * Index
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        return view('backend::debug', [
            'content' => ResourceIndex::make(),
        ]);
    }
}
