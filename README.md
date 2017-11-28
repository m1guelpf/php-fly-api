# PHP Fly.io API Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/m1guelpf/fly-api.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/fly-api)
[![Software License](https://img.shields.io/github/license/m1guelpf/php-fly-api.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/m1guelpf/php-fly-api/master.svg?style=flat-square)](https://travis-ci.org/m1guelpf/php-fly-api)
[![Total Downloads](https://img.shields.io/packagist/dt/m1guelpf/fly-api.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/fly-api)

This package makes it easy to interact with [the Fly.io API](https://fly.io/docs/api/).

## Requirements

This package requires PHP >= 5.5.

## Installation

You can install the package via composer:

``` bash
composer require m1guelpf/fly-api
```

## Usage

You must pass a Guzzle client and the API token to the constructor of `M1guelpf\FlyAPI\Fly`.

``` php
$fly = new \M1guelpf\FlyAPI\Fly('YOUR_FLY_API_TOKEN');
```

or you can skip the token and use the `connect()` method later

``` php
$fly = new \M1guelpf\FlyAPI\Fly();

$fly->connect('YOUR_FLY_API_TOKEN');
```

### Get Hostnames
``` php
$fly->getHostnames($slug);
```

### Create Hostname
``` php
$fly->createHostname($slug, $hostname);
```

### Get Hostname
``` php
$fly->getHostname($slug, $hostname);
```

### Create Backend
``` php
$fly->createBackend($slug, $name, $type, $settings);
```

### Create Rule
``` php
$fly->createRule($slug, $hostname, $backend_id, $action_type, $path, $priority, $path_replacement);
```

### Get the Guzzle Client

``` php
$fly->getClient();
```

### Set the Guzzle Client

``` php
$client = new \GuzzleHttp\Client(); // Example Guzzle client
$fly->setClient($client);
```
where $client is an instance of `\GuzzleHttp\Client`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email soy@miguelpiedrafita.com instead of using the issue tracker.

## Credits

- [Miguel Piedrafita](https://github.com/m1guelpf)
- [All Contributors](../../contributors)

## License

The MIT License. Please see [License File](LICENSE.md) for more information.
