<?php

/**
 * This file is part of the Wisdom project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$factory = new React\Dns\Resolver\Factory();
$resolver = $factory->create('8.8.8.8', $loop);

$connFactory = function ($ip) use ($loop) {
    $fd = stream_socket_client("tcp://$ip:43");
    return new React\Socket\Connection($fd, $loop);
};

$domains = array(
    'umpirsky.com',
    'umpirsky.net',
);

$wisdom = new Wisdom\Wisdom(new React\Whois\Client($resolver, $connFactory));
$wisdom->check($domains, function ($domain, $available) {
    printf('Domain %s is %s.%s', $domain, $available ? 'available' : 'taken', PHP_EOL);
});

echo 'Checking domains...'.PHP_EOL;

$loop->run();

// Outputs:
// Checking domains...
// Domain umpirsky.com is taken.
// Domain umpirsky.net is available.
