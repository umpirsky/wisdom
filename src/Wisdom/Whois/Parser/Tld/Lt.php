<?php

/**
 * This file is part of the Wisdom project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wisdom\Whois\Parser\Tld;

use Wisdom\Whois\Parser\AbstractParser;

/**
 * Whois parser for .lt domains.
 *
 * @author Jaroslav Petrusevic (huglester@gmail.com)
 */
class Lt extends AbstractParser
{
    public function isAvailable()
	{
        // we strip multiple spaces here
        $this->whois = preg_replace("/\s/", '', $this->whois);

        return $this->contains('Status:available');
    }
}
