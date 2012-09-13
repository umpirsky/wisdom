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
        $resolver
            ->expects($this->once())
            ->method('resolve')
            ->with(substr(strrchr($domain, '.'), 1).'.whois-servers.net')
            ->will($this->returnCallback(function ($domain, $callback) {
                call_user_func($callback, null);
            }))
        ;

        $conn = $this->getMockBuilder('React\Whois\Stub\ConnectionStub')
            ->setMethods(array(
                'isReadable', 'pause', 'getRemoteAddress', 'resume', 'pipe', 'close', 'isWritable', 'write', 'end',
            ))
            ->getMock();

        $connFactory = function ($host) use ($conn) {
            return $conn;
        };

        $wisdom = new Wisdom(new Client($resolver, $connFactory));
        $wisdom->check($domain, $callback);

        $conn->emit('data', array($whois));
        $conn->emit('close');
    }

    public function testCheckDataProvider()
    {
        $data = array();
        $domains = array(
            'umpirsky-wisdom' => true,
            'google'          => false,
        );
        $tlds = array(
            '.com',
            '.net',
            '.io',
        );

        foreach ($domains as $domain => $available) {
            foreach ($tlds as $tld) {
                $data[] = array(
                    $domain.$tld,
                    file_get_contents(__DIR__.'/Fixtures/whois/'.$domain.$tld),
                    $available
                );
            }
        }

        return $data;
    }
}
