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

namespace Pzs\Bundle\WCFCoreBundle\Service\Cache;

use Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface;

/**
 * Provides functionality for caching.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
interface CacheServiceInterface
{
    /**
     * Returns the cached value for the given cache builder and parameters.
     * If such a value is not yet existing, the related cache will be built.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface $cacheBuilder the cache builder
     * @param string                                                        $arrayIndex   optional
     * @param array                                                         $parameters   optional
     *
     * @throws    \Pzs\Bundle\WCFCoreBundle\Exception\SystemException                if the cache resource does not have the specified array index
     * @return    mixed
     */
    public function get(CacheBuilderInterface $cacheBuilder, $arrayIndex = '', array $parameters = array());

    /**
     * Caches given data under given cacheName and parameters.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface $cacheBuilder the cache builder
     * @param array                                                         $parameters   optional
     */
    public function set(CacheBuilderInterface $cacheBuilder, array $parameters = array());

    /**
     * Sets the cache under cacheName with given parameters as outdated.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface $cacheBuilder the cache builder
     * @param array                                                         $parameters   optional
     */
    public function reset(CacheBuilderInterface  $cacheBuilder, array $parameters = array());

    /**
     * Resets all caches.
     *
     * Should only be used if necessary as the next request will have to load all data from database.
     */
    public function resetAll();

    /**
     * Returns cache index hash.
     *
     * @param array $parameters
     *
     * @return    string
     */
    public function getCacheIndex(array $parameters);
}
