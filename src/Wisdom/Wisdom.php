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

use React\Promise\When;
use React\Whois\Client;
use Wisdom\Whois\Parser\Factory;

/**
 * Parses whois data to determine domain availability.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Wisdom
{
    /**
     * Whois client.
     *
     * @var Client
     */
    private $client;

    /**
     * @param Client $client whois client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Checks domain availability.
     *
     * @param string|array $domain
     */
    public function check($domain)
    {
        return $this->client
            ->query($domain)
            ->then(function ($result) use ($domain) {
                return Factory::create($domain, $result)->isAvailable();
            });
    }

    /**
     * Checks domain availability of multiple domains.
     *
     * @param array $domains
     */
    public function checkAll(array $domains)
    {
        return When::map($domains, array($this, 'check'))
            ->then(function ($statuses) use ($domains) {
                return array_combine($domains, $statuses);
            });

    }
}
