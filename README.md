Wisdom [![Build Status](https://secure.travis-ci.org/umpirsky/wisdom.png)](http://travis-ci.org/umpirsky/wisdom)
======

Domain availability checker based on [React](http://nodephp.org).

## Installation

The recommended way to install Wisdom is through
[composer](http://getcomposer.org).

```json
{
    "require": {
        "umpirsky/wisdom": "dev-master"
    }
}
```

## Example

```php
<?php

$wisdom = new Wisdom\Wisdom($client);
$wisdom->check('umpirsky.com', function ($domain, $available) {
    printf('Domain %s is %s.%s', $domain, $available ? 'available' : 'taken', PHP_EOL);
});

echo 'Checking domain...'.PHP_EOL;

$loop->run();

// Outputs:
// Checking domain...
// Domain umpirsky.com is taken.
```

See more [examples](https://github.com/umpirsky/wisdom/tree/master/examples).

## Tests

To run the test suite, you need [PHPUnit](https://github.com/sebastianbergmann/phpunit).

    $ phpunit

## License

Wisdom is licensed under the MIT license.
