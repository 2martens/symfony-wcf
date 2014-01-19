<?php
/**
 * LICENSE:
 * This file is part of the Symfony-WCF.
 *
 * The Symfony-WCF is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * The Ultimate CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with the Symfony-WCF.  If not, see {@link http://www.gnu.org/licenses/}.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */

namespace Pzs\Bundle\WCFCoreBundle\Util;
use Pzs\Bundle\WCFCoreBundle\Exception\SystemException;

/**
 * Represents a callback.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
final class Callback
{
    /**
     * encapsulated callback
     * @var	callback
     */
    private $callback = null;

    /**
     * Creates new instance of Callback.
     *
     * @param callable $callback The callback
     *                           
     * @throws SystemException
     */
    public function __construct($callback)
    {
        if (!is_callable($callback)) {
            throw new SystemException('Given callback is not callable.');
        }

        $this->callback = $callback;
    }

    /**
     * Invokes the callback.
     *
     * All parameters are simply passed through.
     *
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->callback, func_get_args());
    }
}
 
