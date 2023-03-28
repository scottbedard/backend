# `bedard/backend`

[![CI](https://github.com/scottbedard/backend/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/scottbedard/backend/actions)
[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/scottbedard/backend/blob/main/LICENSE)

This project is in early development, things will likely change. Proceed with caution.

[View live sandbox →](https://backend.scottbedard.net)

## Installation

A backend for Laravel applications. More documentation to come.

## Controllers

Controllers manage the backend areas of your application. They are defined using `yaml` files, and use the excellent [Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction) package to create protected routes and APIs. In most situations, you'll find this file is all you need to create standard lists and forms. As an example, let's make a controller to manage our application's users. We can scaffold our controller files with the following command.

```bash
php artisan backend:controller users
```

A new controller file should now exist at `app/Backend/users.yaml`. Here we can define permissions, routes, and other settings for this backend area. To understand how these work, let's look at our new `edit` route, and some of the other config options.

```yaml
id: users

model: App\Models\User

permissions:
    - view users
    
routes:
    edit:
        page: form
        path: /{id}/edit
        permissions:
            - create users
        options:
            # ...
```

- **`id`** A unique identifier to namespace the controller routes. If none is defined, the file name will be used.
- **`model`** The model associated with this controller's resource.
- **`permissions`** The permissions required to view routes associated with this controller.
- **`routes`**
  - **`edit`** A unique name that maps to a controller method.
    - **`page`** The page ro render for our route. We'll discuss these more later.
    - **`path`** URL path to our route, defined using [Laravel's normal routing syntax](https://laravel.com/docs/routing#route-parameters)
    - **`permissions`** Additional permissions required to access this route.
    - **`options`** Any additional data needed for the page.

For full control of the request, you can extend a `Bedard\Backend\BackendController` and assign it to the `class` property of this file.

## Pages

No documentation yet, check back later.

## Super admins

The `super admin` role enables all other roles and permissions, **<ins>including the ability to create other super admins</ins>**. If needed, this role can be renamed using the `BACKEND_SUPER_ADMIN_ROLE` environment variable. Execute the following to create a super admin.

```sh
php artisan backend:assign-role {id} 'super admin'
```

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
