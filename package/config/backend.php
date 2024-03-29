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
        __DIR__ . '/../app/Backend',
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

    'super_admin_role' => env('BACKEND_SUPER_ADMIN_ROLE', 'super-admin'),

    /*
    |--------------------------------------------------------------------------
    | Admin permission
    |--------------------------------------------------------------------------
    |
    | The name of your admin role. Any user who accesses the backend will
    | need to have this permission.
    |
    */

    'admin_permission' => env('BACKEND_ADMIN_PERMISSION', 'admin'),

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
        'blade' => \Bedard\Backend\Config\Plugins\BladePlugin::class,
        'crud' => \Bedard\Backend\Config\Plugins\CrudPlugin::class,
        'form' => \Bedard\Backend\Config\Plugins\FormPlugin::class,
        'list' => \Bedard\Backend\Config\Plugins\ListPlugin::class,
        'redirect' => \Bedard\Backend\Config\Plugins\RedirectPlugin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Column aliases
    |--------------------------------------------------------------------------
    |
    | These aliases are used by the list plugin and map to the `type` option.
    |
    */

    'columns' => [
        'blade' => \Bedard\Backend\Config\Plugins\List\BladeColumn::class,
        'date' => \Bedard\Backend\Config\Plugins\List\DateColumn::class,
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
        'blade' => \Bedard\Backend\Config\Plugins\Form\BladeField::class,
        'datetime' => \Bedard\Backend\Config\Plugins\Form\DatetimeField::class,
    ],
];
