Wisdom [![Build Status](https://secure.travis-ci.org/umpirsky/wisdom.png)](http://travis-ci.org/umpirsky/wisdom)
======
<img src="https://raw.github.com/umpirsky/wisdom/master/icon/icon.png" />

Domain availability checker based on [React/Whois](https://github.com/react-php/whois).
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

$wisdom = new Wisdom($client);
$wisdom->check('umpirsky.com', function ($domain, $available) {
    printf('Domain %s is %s.', $domain, $available ? 'available' : 'taken');
});

// Outputs:
// Domain umpirsky.com is taken.
```

See more [examples](https://github.com/umpirsky/wisdom/tree/master/examples).

## Adding support for a TLD

This example uses the `ch` domain, replace `.ch` with your own one.

* First, create the test cases:
```
$ whois umpirsky-wisdom.ch > tests/Wisdom/Fixtures/whois/umpirsky-wisdom.ch
$ whois google.ch > tests/Wisdom/Fixtures/whois/google.ch
```

  Modify the `testCheckDataProvider` in `tests/Wisdom/WisdomTest.php` to
  include `.ch`.

* Run the tests to make sure they fail.

* Identify a string in the `umpirsky-wisdom` variant that identifies the
  domain as available.

* Create the `Wisdom\Whois\Parser\Ch` class and implement the `isAvailable`
  method.

* Run the tests to make sure they pass.

* Create a pull request on GitHub.

## Tests

To run the test suite, you need [PHPUnit](https://github.com/sebastianbergmann/phpunit).

    $ phpunit

## License

Wisdom is licensed under the MIT license.
