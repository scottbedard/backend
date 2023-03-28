<?php

return [

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
    | Guest redirect
    |--------------------------------------------------------------------------
    |
    | Unauthenticated users will be redirected here.
    |
    */

    'guest_redirect' => env('BACKEND_GUEST_REDIRECT', '/'),

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
    | Guest redirect
    |--------------------------------------------------------------------------
    |
    | Route middleware alias to restrict access to the backend. Users must be
    | authenticated and have atleast one backend permission to pass middleware.
    |
    */

    'middleware_alias' => env('BACKEND_MIDDLEWARE_ALIAS', 'backend'),

    /*
    |--------------------------------------------------------------------------
    | Guest redirect
    |--------------------------------------------------------------------------
    |
    | Route middleware alias to restrict access to the backend. Users must be
    | authenticated and have atleast one backend permission to pass middleware.
    |
    */

    'backend_directory' => app_path(env('BACKEND_DIRECTORY', 'Backend')),
    
    /*
    |--------------------------------------------------------------------------
    | Super admin role
    |--------------------------------------------------------------------------
    |
    | The name of your super admin role. This role grants all other roles and
    | permissions, including the ability to create other super admins.
    |
    */

    'super_admin_role' => env('BACKEND_SUPER_ADMIN_ROLE', 'super admin'),

    /*
    |--------------------------------------------------------------------------
    | Page types
    |--------------------------------------------------------------------------
    |
    | This registers a unique alias to be used in yaml configs. The form and
    | list are built in, but you can add your own.
    |
    */

    'pages' => [
        'form' => \Bedard\Backend\Pages\FormPage::class,
        'list' => \Bedard\Backend\Pages\ListPage::class,
    ],

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
