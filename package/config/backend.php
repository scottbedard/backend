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
    | User
    |--------------------------------------------------------------------------
    |
    | The user model associated with your application.
    |
    */

    'user' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Guest redirect
    |--------------------------------------------------------------------------
    |
    | Users that are not logged in will be redirected here
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
    | Logout href
    |--------------------------------------------------------------------------
    |
    | This defines where to link the logout button to.
    |
    */

    'logout_href' => '/logout',

    /*
    |--------------------------------------------------------------------------
    | Backend directories
    |--------------------------------------------------------------------------
    |
    | Directory to scan for backend .yaml files.
    |
    */

    'backend_directories' => [
        __DIR__ . '/../packages/bedard/backend/src/Backend',
    ],

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
    | Plugin aliases
    |--------------------------------------------------------------------------
    |
    | These are unique aliases to be referenced from yaml files. A few are
    | built in for basic crud pages, but you're welcome to add your own!
    |
    */

    'plugins' => [
        'blade' => \Bedard\Backend\Plugins\BladePlugin::class,
        'form' => \Bedard\Backend\Plugins\FormPlugin::class,
        'list' => \Bedard\Backend\Plugins\ListPlugin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Field aliases
    |--------------------------------------------------------------------------
    |
    | These aliases are used by the form plugin and map to the `type` option.
    |
    */

    'fields' => [
        'input' => \Bedard\Backend\Form\InputField::class,
    ],
];
