<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Components\Block;
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
            'content' => Block::class('grid gap-6')->items([
                Block::class('border-4 border-primary-500 p-6')->text('Hello'),

                Block::text('Foo'),

                Block::text('Bar'),
            ]),
        ]);
    }
}
