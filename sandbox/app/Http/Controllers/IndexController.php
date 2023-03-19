<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function index(LoginRequest $request): Response
    {
        return view('login');
    }
}
