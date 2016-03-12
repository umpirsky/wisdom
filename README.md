<h3 align="center">
    <a href="https://github.com/umpirsky">
        <img src="https://farm2.staticflickr.com/1709/25098526884_ae4d50465f_o_d.png" />
    </a>
</h3>
<p align="center">
  <a href="https://github.com/umpirsky/Symfony-Upgrade-Fixer">symfony upgrade fixer</a> &bull;
  <a href="https://github.com/umpirsky/Twig-Gettext-Extractor">twig gettext extractor</a> &bull;
  <a href="https://github.com/umpirsky/wisdom">wisdom</a> &bull;
  <a href="https://github.com/umpirsky/centipede">centipede</a> &bull;
  <a href="https://github.com/umpirsky/PermissionsHandler">permissions handler</a> &bull;
  <a href="https://github.com/umpirsky/Extraload">extraload</a> &bull;
  <a href="https://github.com/umpirsky/Gravatar">gravatar</a> &bull;
  <a href="https://github.com/umpirsky/locurro">locurro</a> &bull;
  <a href="https://github.com/umpirsky/country-list">country list</a> &bull;
  <a href="https://github.com/umpirsky/Transliterator">transliterator</a>
</p>

Wisdom [![Build Status](https://secure.travis-ci.org/umpirsky/wisdom.png)](http://travis-ci.org/umpirsky/wisdom)
======
<img src="https://raw.github.com/umpirsky/wisdom/master/icon/icon.png" />

Domain availability checker based on [React/Whois](https://github.com/reactphp/whois).
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

$domain = 'umpirsky.com';
$wisdom = new Wisdom($client);
$wisdom
    ->check($domain)
    ->then(function ($available) use ($domain) {
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

* Run the tests to make sure they fail.

* Identify a string in the `umpirsky-wisdom` variant that identifies the
  domain as available.

* Create the `Wisdom\Whois\Parser\Tld\Ch` class and implement the `isAvailable`
  method.

* Run the tests to make sure they pass.

* Create a pull request on GitHub.

## Tests

To run the test suite, you need [PHPUnit](https://github.com/sebastianbergmann/phpunit).

    $ phpunit

## License

Wisdom is licensed under the MIT license.
