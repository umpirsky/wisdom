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
    public function testCheck($domain, $whois, $available)
    {
        $callback = $this->createCallableStub();
        $callback
            ->expects($this->once())
            ->method('__invoke')
            ->with($domain, $available)
        ;

        $resolver = $this->getMockBuilder('React\Dns\Resolver\Resolver')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $conn = $this->getMockBuilder('React\Whois\Stub\ConnectionStub')
            ->setMethods(array(
                'isReadable', 'pause', 'getRemoteAddress', 'resume', 'pipe', 'close', 'isWritable', 'write', 'end',
            ))
            ->getMock()
        ;

        $connFactory = function ($host) use ($conn) {
            return $conn;
        };

        $client = new Client($resolver, $connFactory);

        $self = $this;
        $client->resolveWhoisServer($domain, function ($address) use ($self, $resolver, $domain, $callback) {
            $resolver
                ->expects($self->once())
                ->method('resolve')
                ->with($address)
                ->will($this->returnCallback(function ($domain, $callback) {
                    // whois.nic.io
                    call_user_func($callback, '193.223.78.152');
                }))
            ;
        });

        $wisdom = new Wisdom($client);
        $wisdom->check($domain, $callback);

        $conn->emit('data', array($whois));
        $conn->emit('close');
    }

    public function testCheckDataProvider()
    {
        return array(
            array(
                'umpirsky.net',
                file_get_contents(__DIR__.'/Fixtures/whois/umpirsky.net'),
                true
            )
        );
    }
}
