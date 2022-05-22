<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Models\BackendSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendSettingsController extends Controller
{
    /**
     * Toggle a boolean setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggle()
    {
        return 'hello';
    }
}
