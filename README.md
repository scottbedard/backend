# `bedard/backend`

[![CI](https://github.com/scottbedard/backend/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/scottbedard/backend/actions)
[![License](https://img.shields.io/github/license/scottbedard/backend?color=blue)](https://github.com/scottbedard/backend/blob/main/LICENSE)

This project is in early development, things will likely change. Proceed with caution.

[View live sandbox →](https://backend.scottbedard.net)

# Installation

There are been no releases yet, check back later.

# Basic usage

This package works using the excellent [Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction) package. More documentation to come.

# Super admins

The `super admin` role enables all other roles and permissions, <ins>including the ability to create other super admins</ins>. If needed, this role can be renamed using the `BACKEND_SUPER_ADMIN_ROLE` environment variable. Execute the following to create a super admin.

```sh
php artisan backend:assign-role {id} 'super user'
```

# License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
