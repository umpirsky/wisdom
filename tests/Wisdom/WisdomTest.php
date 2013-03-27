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
use Symfony\Component\Finder\Finder;

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
            ->with($available)
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
                'isReadable', 'pause', 'getRemoteAddress', 'resume', 'close', 'isWritable', 'write', 'end',
            ))
            ->getMock();

        $connFactory = function ($host) use ($conn) {
            return $conn;
        };

        $wisdom = new Wisdom(new Client($resolver, $connFactory));
        $wisdom
            ->check($domain)
            ->then($callback)
        ;

        $conn->emit('data', array($whois));
        $conn->emit('end');
    }

    public function testCheckDataProvider()
    {
        $data = array();

        $finder = new Finder();

        foreach ($finder->files()->in(__DIR__.'/Fixtures/whois') as $domain) {
            $data[] = array(
                $domain->getFilename(),
                file_get_contents($domain->getRealPath()),
                0 === strpos($domain->getFilename(), 'umpirsky-wisdom')
            );
        }

        return $data;
    }
}
