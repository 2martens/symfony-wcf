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
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */

namespace Pzs\Bundle\WCFCoreBundle\Service\Cache;

use Pzs\Bundle\WCFCoreBundle\Cache\Builder\ICacheBuilder;

/**
 * Provides functionality for caching.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */
interface CacheServiceInterface
{
	/**
	 * Returns the cached value for the given cache builder and parameters.
	 * 
	 * @param	\Pzs\Bundle\WCFCoreBundle\Cache\Builder\ICacheBuilder	$cacheBuilder	the cache builder
	 * @param	array													$parameters		optional
	 * 
	 * @return	mixed
	 */
	public function get(ICacheBuilder $cacheBuilder, array $parameters = array());
	
	/**
	 * Caches given data under given cacheName and parameters.
	 * 
	 * @param	\Pzs\Bundle\WCFCoreBundle\Cache\Builder\ICacheBuilder	$cacheBuilder	the cache builder
	 * @param	array													$data
	 * @param	array													$parameters		optional
	 */
	public function set(ICacheBuilder $cacheBuilder, array $data, array $parameters = array());
	
	/**
	 * Sets the cache under cacheName with given parameters as outdated.
	 * 
	 * @param	\Pzs\Bundle\WCFCoreBundle\Cache\Builder\ICacheBuilder	$cacheBuilder	the cache builder
	 * @param	array													$parameters		optional
	 */
	public function reset(ICacheBuilder $cacheBuilder, array $parameters = array());
	
	/**
	 * Resets all caches.
	 * 
	 * Should only be used if necessary as the next request will have to load all data from database.
	 */
	public function resetAll();
	
	/**
	 * Returns cache index hash.
	 *
	 * @param	array	$parameters
	 * @return	string
	 */
	public function getCacheIndex(array $parameters);
}
