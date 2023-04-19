# `bedard/backend`

[![CI](https://github.com/scottbedard/backend/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/scottbedard/backend/actions)
[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/scottbedard/backend/blob/main/LICENSE)

Every application eventually needs a backend. This is sometimes an after thought though, and can require extra work right when a backend is needed most! A rushed backend can become poorly maintained, under built, and the source of endless tech debt. This project hopes to be a solution.

The process will look something like this...

1. Run composer install
2. Create some `yaml` files
3. Enjoy an awesome backend with flexible priveleges and configurations

That said, this is in very early development, take everything you see with a grain of salt.

[View live sandbox →](https://backend.scottbedard.net)


## Installation

No docs yet, check back later.

## Basic usage

Backend areas are defined using `yaml` files. Let's look at an example `users.yaml` file and see how they work.

```yaml
# these define the permissions required to access the controller.
# this includes the nav, routes, and all other items
permissions:
    - read users

# this property adds an item to the main backend navigation.
# see the notes below for more info on icons
nav:
    href: /backend/users
    icon: users
    label: Users
    
# the eloquent model that plugins should use.
# if needed, this can be overwritten for individual routes.
model: App\Models\User

# subnavs add a secondary nav bar to all of this controller's routes.
# to restrict link visibility, define a permissions array.
subnav:
    -
        href: /backend/users
        icon: users
        label: Users
    -
        href: /backend/users/groups
        icon: folder
        label: Groups
        permissions:
            - read user groups

# routes are managed by plugins. see the documentation below for info on the
# built-in ones, and on how to create your own.
routes:

    # routes can define a path property, null values target the controller base.
    # if none is defined, it will be inferred from the route name (like "create" below!).
    index:
        path: null
        plugin: list
        options:
            # ...

    # routes inherit the permissions of their controller, but may also define their own
    # to be required in addition to these.
    create:
        plugin: form
        options:
            # ...
        permissions:
            - create users
```

## Permissions

Permissions are provided by Spatie's awesome [`laravel-permission`](https://github.com/spatie/laravel-permission) package. By default, a `super admin` role enables all other roles and permissions, **<ins>including the ability to create other super admins</ins>**. To create a super admin, execute the following command.

```sh
php artisan backend:assign-role {id} 'super admin'
```

Several config elements already support custom permissions, more docs to come...

## Plugins

Plugins are still being developed. In general, they handle requests and returning a [blade template](https://laravel.com/docs/10.x/blade). Plugins have access to the full config, and can add their own behavior around that data. A few plugins are aliased by default. This can be customized in `config/backend.php`.

```php
return [
    'plugins' => [
        'blade' => \Bedard\Backend\Plugins\BladePlugin::class,
        'form' => \Bedard\Backend\Plugins\FormPlugin::class,
        'list' => \Bedard\Backend\Plugins\ListPlugin::class,
    ],
]
```

### Blade

This plugin renders a blade template.

```yaml
plugin: blade
options:
    view: namespace::view
```

### List

Lists are being developed, check back later.

```yaml
plugin: list
options:
    schema:
        id:
            type: number
        email:
            type: email
        created_at:
            type: date
        updated_at:
            label: Last seen
            type: timeago
```

### Form

Forms haven't been developed yet.

```yaml
plugin: form
options:
    # ...
```

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
