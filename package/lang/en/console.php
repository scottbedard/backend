<?php

return [
    'authorize' => [
        'abort' => 'Action aborted, no roles were granted.',
        'description' => 'Grant user a role',
        'force' => 'Skip safety checks',
        'success' => 'Successfully assigned role to user.',
        'super_admin_confirm' => 'Are you sure you wish to continue?',
        'super_admin_info' => 'You\'re about to create a super admin. This grants all roles and permissions, including the ability to create other super admins.',
        'user_not_found' => 'User not found.',
    ],

    'controller' => [
        'docs' => 'Add basic documentation comments',
        'description' => 'Create a backend controller',
        'force' => 'Skip safety checks',
        'model' => 'Set default names and permissions for model',
        'success' => 'Successfully created controller.',
        'terse' => 'Create minimal output',
    ],
];
