<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Models\BackendSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Toggle a boolean setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
        $setting = Auth::user()
            ->backendSettings()
            ->firstOrNew(['key' => $request->key]);

        $setting->value = ! (bool) $setting->value;

        $setting->save();

        return [
            'setting' => $setting,
        ];
    }
}
