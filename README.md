# `bedard/backend`

[![Test](https://github.com/scottbedard/backend/actions/workflows/test.yml/badge.svg)](https://github.com/scottbedard/backend/actions/workflows/test.yml)

This is just an experiment, proceed with caution.

# Installation

If this package is ever released, a more thorough installation guide will be provided. For now, the package can be installed for local development by executing the following.

```bash
# clone repository and create symlink for local package
$ git clone git@github.com:scottbedard/backend.git backend && cd "$_"

$ ln -s $(realpath package) $(realpath application/packages/bedard/backend)

# install dependencies and configuration application
$ composer install -d application

$ php application/artisan vendor:publish

# run migrations
$ php artisan migrate
```

# Permissions

This package builds on top of Spatie's excellent [Laravel Permission](https://github.com/spatie/laravel-permission) package. We do this using a "two word" syntax. The first word representing the action being allowed, and the second word representing the target of that action. For example, to allow an admin to create other users, they would require the "create users" permission.

### Authorization

Permissions can be checked for in a couple different ways. The first is to use the `Backend::check` method directly.

```php
use Backend;

if (Backend::check($user, 'delete posts')) {
    // ...
}
```

Alternatively, you may use the `can` and `cannot` methods exposed in the `User` class. See Laravel's [authorization documentation](https://laravel.com/docs/9.x/authorization#via-the-user-model) for more on these methods.

```php
if ($user->can('delete posts')) {
    // ...
}
```

For use inside Blade templates, use the `@can` and `@cannot` directives. See the [documentation here](https://laravel.com/docs/9.x/authorization#via-blade-templates) for more info.

```html
@can('update posts')
    ...
@endcan
```

### Special permissions

There are a few special permissions to be aware of. The most importantly is `super admin`. Users with this permission are granted full access to everything, including the ability to create other super admins.

To grant users access to an entire area, use the `manage` permission. For example, a user with the `manage posts` permission would be granted full access to that resource (`create posts`, `delete posts`, etc...).

The last special permission is the `access` keyword. This isn't a permission given to users directly, but is used to check if a user has a permission related to that resource. For example, a user with an `update posts` permission would also pass checks for `access posts`.

# Resources

TBD

# License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
