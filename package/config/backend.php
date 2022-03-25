<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Guest redirect
    |--------------------------------------------------------------------------
    |
    | Unauthenticated users will be redirected here.
    |
    */

    'guest_redirect' => env('BACKEND_GUEST_REDIRECT', '/login'),

    /*
    |--------------------------------------------------------------------------
    | Path
    |--------------------------------------------------------------------------
    |
    | This value defines the application backend path. It will be prefixed to
    | all backend routes, and only users with admin permissions will be able
    | to access them.
    |
    */

    'path' => env('BACKEND_PATH', 'backend'),

    /*
    |--------------------------------------------------------------------------
    | Unauthorized redirect
    |--------------------------------------------------------------------------
    |
    | Authenticated users without backend permissions will be redirected here.
    |
    */

    'unauthorized_redirect' => env('BACKEND_UNAUTHORIZED_REDIRECT', '/'),
     

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    |
    | The user model associated with your application.
    |
    */

    'user' => \App\Models\User::class,
];
