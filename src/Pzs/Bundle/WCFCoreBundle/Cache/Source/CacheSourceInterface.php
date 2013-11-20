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
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */

namespace Pzs\Bundle\WCFCoreBundle\Cache\Source;

/**
 * Defines functionality of a cache source.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
interface CacheSourceInterface
{
    /**
     * Flushes a specific cache, optionally removing caches which share the same name.
     *
     * @param string  $cacheName
     * @param boolean $useWildcard can be used if you have a common cache name with different parameters each
     */
    public function flush($cacheName, $useWildcard);

    /**
     * Clears the cache completely.
     */
    public function flushAll();

    /**
     * Returns a cached variable.
     *
     * @param string  $cacheName
     * @param integer $maxLifetime
     *
     * @return    mixed
     */
    public function get($cacheName, $maxLifetime);

    /**
     * Stores a variable in the cache.
     *
     * @param string  $cacheName
     * @param mixed   $value
     * @param integer $maxLifetime
     */
    public function set($cacheName, $value, $maxLifetime);
}
