# `bedard/backend`

[![CI](https://github.com/scottbedard/backend/actions/workflows/test.yml/badge.svg?branch=next)](https://github.com/scottbedard/backend/actions)

This project is in early development, things will likely change. Proceed with caution.

## Installation

No documentation yet.

## Super admins

The `super admin` role enables all other roles and permissions, <ins>including the ability to create other super admins</ins>. If needed, this role can be renamed using the `BACKEND_SUPER_ADMIN_ROLE` environment variable. Execute the following to create a super admin.

```sh
php artisan backend:assign-role {id} 'super user'
```
