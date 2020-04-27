# PHP Weekday

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chinleung/php-weekday.svg?style=flat-square)](https://packagist.org/packages/chinleung/php-weekday)
[![Build Status](https://img.shields.io/travis/chinleung/php-weekday/master.svg?style=flat-square)](https://travis-ci.org/chinleung/php-weekday)
[![Quality Score](https://img.shields.io/scrutinizer/g/chinleung/php-weekday.svg?style=flat-square)](https://scrutinizer-ci.com/g/chinleung/php-weekday)
[![Total Downloads](https://img.shields.io/packagist/dt/chinleung/php-weekday.svg?style=flat-square)](https://packagist.org/packages/chinleung/php-weekday)

Easily get name of weekday and value from name between different languages.

## Installation

You can install the package via composer:

```bash
composer require chinleung/php-weekday
```

## Usage

### Retrieve a name from a value

``` php
Weekday::getNameFromValue(0, 'en'); // Sunday
(new Weekday(0, 'en'))->getName(); // Sunday
```

### Retrieving a name from a value for a different locale

``` php
Weekday::getNameFromValue(0, 'fr'); // Dimanche
(new Weekday(0, 'en'))->getName('fr'); // Dimanche
```

### Retrieving a value from the name

``` php
Weekday::getValueFromName('Sunday', 'en'); // 0
Weekday::getValueFromName('Lundi', 'fr'); // 1
(new Weekday('wednesday', 'en'))->getName(); // 3
```

### Retrieving all names for a locale

``` php
Weekday::getNames('en'); // ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
```

### Changing the locale of an instance

``` php
(new Weekday(1, 'en'))->setLocale('fr')->getName(); // Lundi
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email hello@chinleung.com instead of using the issue tracker.

## Credits

- [Chin Leung](https://github.com/chinleung)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
