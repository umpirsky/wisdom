<?php

/**
 * This file is part of the Wisdom project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wisdom\Whois\Parser;

/**
 * Abstract parser used by tld parsers.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * Domain name.
     *
     * @var string
     */
    protected $domain;

    /**
     * Whois data.
     *
     * @var string
     */
    protected $whois;

    /**
     * @param string $domain
     * @param string $whois
     */
    public function __construct($domain, $whois)
    {
        $this->domain = $domain;
        $this->whois = $whois;
    }

    /**
     * Checks if whois contains given token.
     *
     * @param string $token
     * @return bool
     */
    protected function contains($token)
    {
        return stripos($this->whois, sprintf($token, $this->domain)) !== false;
    }
}
