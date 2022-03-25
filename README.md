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

## Resources

TBD

## Permissions

TBD

## License

[MIT](https://github.com/scottbedard/backend/blob/master/LICENSE)

Copyright (c) 2022-present, Scott Bedard
