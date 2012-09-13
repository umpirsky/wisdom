<?php

/**
 * This file is part of the Wisdom project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wisdom\Exception;

/**
 * Thrown when whois parser is not found for given TLD.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class WhoisParserNotFoundException extends \InvalidArgumentException
{
}
