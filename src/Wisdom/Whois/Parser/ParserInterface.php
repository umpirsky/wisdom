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
 * Whois parser interface.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
interface ParserInterface
{
    /**
     * Parses whois data to determine domain availability.
     *
     * @return bool
     */
    public function isAvailable();
}
