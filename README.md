# `bedard/backend`

[![Test](https://github.com/scottbedard/backend/actions/workflows/test.yml/badge.svg)](https://github.com/scottbedard/backend/actions/workflows/test.yml)

This is just an experiment, proceed with caution.

## Installation

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

## Permissions

This package contains a fine-grained permissions system to control access the backend. The two main aspects of a permission are the `area` and `code`. The area defines what resources or actions the permission applies to, and the code defines what kind of access is permitted.

For example, imagine an application with a `Post` model, and you would like a permission to allow only create actions. That permission might be created using the `authorize` command.

```php
Backend::authorize($user, 'posts', 'create');
```

Similarly, permisions may be revoked using the `deauthorize` command.

```php
Backend::deauthorize($user, 'posts', 'create');
```

To check for a given permission, use the `check` command.

```php
if (Backend::check($user, 'posts', 'create') {
  // ...
}
```

There are two special keywords to be aware of when using permissions. The first, is the `all` keyword, which can apply to both the `area` and `code`. As its name suggests, it can be used to cover all areas or codes. For example, a "super admin" might be created using the following.

```php
Backend::authorize($user, 'all', 'all');
```

Be aware, if a user has the `all` code for an area (or all areas), the `deauthorize` command can only be used to revoke all permissions. Users cannot be demoted to have a smaller scope than they previously had. To do this, use the backend permissions page.

The second keyword to be aware of is `any`, which only applies to checking for area permissions. For example, to check if a user has access to the `posts` area, we might use the following.

```php
if (Backend::check($user, 'posts', 'any') {
  // ...
}
```

## Resources

TBD

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
