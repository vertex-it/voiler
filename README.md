<p align="center"><a href="https://vertex-it.com" target="_blank"><img src="logo-voiler.svg" width="400" alt="Voiler Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/vertex-it/voiler"><img src="https://img.shields.io/packagist/dt/vertex-it/voiler" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/vertex-it/voiler"><img src="https://img.shields.io/packagist/v/vertex-it/voiler" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/vertex-it/voiler"><img src="https://img.shields.io/packagist/l/vertex-it/voiler" alt="License"></a>
</p>

## Installation

This development line targets Laravel 13 and requires PHP 8.3 or later. It uses
Laravel Tinker 3 and Yajra DataTables 13. Applications on Laravel 11 should keep
using the published Voiler 11.x releases until they are ready to upgrade.

Install the package via composer:

```bash
composer require vertex-it/voiler
```

Package compatibility tests run with Orchestra Testbench:

```bash
composer install
composer test -- --fail-on-warning --fail-on-risky --fail-on-deprecation
```

CI resolves dependencies and runs these tests on PHP 8.3, 8.4, and 8.5. This is a
library, so `composer.lock` is not committed; applications should commit their
own lockfile.

You can publish the config:

```bash
php artisan vendor:publish --tag=config
```

You can install tailwind:

```bash
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
```

You can install jquery:

```bash
npm install jquery jquery-cropper jquery-timepicker
```

You can install datatables:

```bash
npm install datatables.net-dt datatables.net-buttons-dt datatables.net-select-dt datatables.net-responsive-dt datatables.net-fixedheader-dt datatables.net-fixedcolumns-dt
```

You can publish the assets:

```bash
php artisan vendor:publish --tag=assets --force
```

## Optional

You can publish the views:

```bash
php artisan vendor:publish --tag=views --force
```

## How to run it locally

Install the project in the same directory as the source project.

In `docker-compose.yml` in `app` service `volumes` parameter add:
```
    volumes:
        - ../voiler:/var/www/voiler
```

In `composer.json` add
```
    "repositories": [
        {
            "type": "path",
            "url": "../voiler"
        }
    ]
```

Delete `composer.lock` and `vendor` and install composer dependencies again.

## Usage

```php
// Usage description here
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mile.panic96@gmail.com instead of using the issue tracker.

## Credits

-   [Mile Panić](https://github.com/vertex-it)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
