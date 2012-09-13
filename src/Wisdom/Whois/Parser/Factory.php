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

use Wisdom\Exception\WhoisParserNotFoundException;

/**
 * Whois parser factory.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Factory
{
    /**
     * Creates whois parser for given domain name.
     *
     * @param string $domain
     * @param string $whois
     * @return Interface
     */
    public static function create($domain, $whois)
    {
        $tld = substr(strrchr($domain, '.'), 1);
        $parserClass = 'Wisdom\\Whois\\Parser\\Tld\\'.ucfirst($tld);
        if (!class_exists($parserClass)) {
            throw new WhoisParserNotFoundException(sprintf(
                'Whois parser for .%s domains not found.',
                $tld
            ));
        }

        return new $parserClass($domain, $whois);
    }
}
