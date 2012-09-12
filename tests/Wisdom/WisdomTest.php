<?php

/**
 * This file is part of the Wisdom project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wisdom;

use React\Whois\TestCase;
use React\Whois\Client;
use React\EventLoop\Factory as EventLoopFactory;
use React\Dns\Resolver\Factory as ResolverFactory;
use React\Socket\Connection;

/**
 * Wisdom test.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class WisdomTest extends TestCase
{
    /**
     * @dataProvider testCheckDataProvider
     */
    public function testCheck($domain, $available)
    {
        $callback = $this->createCallableStub();
        $callback
            ->expects($this->once())
            ->method('__invoke')
            ->with($domain, $available)
        ;

        $loop = EventLoopFactory::create();
        $factory = new ResolverFactory();
        $resolver = $factory->create('8.8.8.8', $loop);

        $connFactory = function ($ip) use ($loop) {
            $fd = stream_socket_client("tcp://$ip:43");
            return new Connection($fd, $loop);
        };

        $wisdom = new Wisdom(new Client($resolver, $connFactory));
        $wisdom->check($domain, $callback);

        $loop->run();
    }

    public function testCheckDataProvider()
    {
        return array(
            array(
                'umpirsky.net',
                true
            ),
            array(
                'umpirsky.com',
                false
            ),
        );
    }
}
