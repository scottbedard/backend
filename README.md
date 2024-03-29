# `bedard/backend`

[![Build](https://img.shields.io/github/actions/workflow/status/scottbedard/backend/ci.yml?style=flat-square)](https://github.com/scottbedard/backend/actions)
[![License](https://img.shields.io/github/license/scottbedard/backend?style=flat-square&color=blue)](https://github.com/scottbedard/backend/blob/main/LICENSE)

It's to soon to tell what this is, but for now, it's an attempt to create powerful backends from simple yaml files. I envision the final product looking something like this,

1. Composer install
2. Artisan generate a few `yaml` files
3. Enjoy an awesome backend with find grained permissions

You're welcome to take a look around, but remember things may not work.

[View live sandbox →](https://backend.scottbedard.net)


## Installation

No documentation yet, check back later.

## Basic usage

Backend areas are defined using `yaml` files. Let's look at an example `users.yaml` to see how they work.

```yaml
# permissions define what credentials are required for this controller.
# these permissions are applied to all controller items (nav, routes, etc...)
permissions:
    - read users

# this property adds an item to the main backend navigation.
# icons may be any valid lucide name (https://lucide.dev)
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

## Common config

Some behavior is being shared between parts of the config.

### `icon`

Icon components are available on the client and server. Any valid [Lucide icon](https://lucide.dev) name is supported.

```yaml
nav:
    icon: rocket
```

### `to`

When `href` is present, a cooresponding `to` should also be available. This `to` property can be a route name, but also a string with keywords for `{backend}` and `{controller}`.

```yaml
nav:
    label: Users
    to: /{backend}/{controller}/users
    
subnav:
    -
        label: Roles
        to: backend.admin.roles
```

## Plugins

Plugins are still being developed. In general though, they handle a request and return a view. Plugins have access to the full config, and can add behavior around that config. The following plugins are aliased by default in `config/backend.php`.

```php
'plugins' => [
    'blade' => \Bedard\Backend\Plugins\BladePlugin::class,
    'form' => \Bedard\Backend\Plugins\FormPlugin::class,
    'list' => \Bedard\Backend\Plugins\ListPlugin::class,
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

Forms are being developed, check back later.

```yaml
plugin: form
options:
    fields:
        name:
            span: 6
            type: text
        email:
            span: 6
            type: email
```

## Permissions

Permissions are provided by the excellent [`laravel-permission`](https://github.com/spatie/laravel-permission) package. By default, a `super-admin` role enables all other roles and permissions, **<ins>including the ability to create other super admins</ins>**. To create a super admin, execute the following command.

```sh
php artisan backend:assign-role {id} 'super admin'
```

Several config elements already support custom permissions, more docs to come...

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
