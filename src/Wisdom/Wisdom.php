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

use React\Whois\Client;

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
     * @param string|array $domains
     * @param callable     $callback
     */
    public function check($domains, $callback)
    {
        foreach ((array) $domains as $domain) {
            $this->client->query($domain, function ($result) use ($domain, $callback) {
                $available = stripos($result, 'No match') !== false;
                $callback($domain, $available);
            });
        }
    }
}
