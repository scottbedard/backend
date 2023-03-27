# `bedard/backend`

[![CI](https://github.com/scottbedard/backend/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/scottbedard/backend/actions)
[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/scottbedard/backend/blob/main/LICENSE)

This project is in early development, things will likely change. Proceed with caution.

[View live sandbox →](https://backend.scottbedard.net)

## Installation

A backend for Laravel applications. More documentation to come.

## Controllers

Controllers manage the backend areas of your application. They are defined using `yaml` files, and can make protected pages with using the excellent [Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction) package.

## Super admins

The `super admin` role enables all other roles and permissions, <ins>including the ability to create other super admins</ins>. If needed, this role can be renamed using the `BACKEND_SUPER_ADMIN_ROLE` environment variable. Execute the following to create a super admin.

```sh
php artisan backend:assign-role {id} 'super admin'
```

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
