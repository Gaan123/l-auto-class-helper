# laravel Auto DI and facade Heleper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dada/l-auto-class-helper.svg?style=flat-square)](https://packagist.org/packages/dada/l-auto-class-helper)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dada/l-auto-class-helper/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/dada/l-auto-class-helper/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/dada/l-auto-class-helper/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/dada/l-auto-class-helper/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dada/l-auto-class-helper.svg?style=flat-square)](https://packagist.org/packages/dada/l-auto-class-helper)

This Package will help you auto bind classes in service provider and give extra tool to extract class

## Installation

You can install the package via composer:

```bash
composer require dada/l-auto-class-helper
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="l-auto-class-helper-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="l-auto-class-helper-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="l-auto-class-helper-views"
```

## Usage

```php
$lAutoClassHelper = new Dada\AutoClassHelper();
echo $lAutoClassHelper->echoPhrase('Hello, Dada!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Gaagn Tamu](https://github.com/Gaan123)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
