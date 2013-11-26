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

use Doctrine\Common\Cache\CacheProvider;
use Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface;
use Pzs\Bundle\WCFCoreBundle\Exception\SystemException;

/**
 * Manages the cache.
 *
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class CacheService implements CacheServiceInterface
{
    /**
     * The cache data.
     * @var array
     */
    private $cacheData;

    /**
     * The cache provider.
     * @var \Doctrine\Common\Cache\CacheProvider
     */
    private $cacheProvider;

    /**
     * Constructor.
     *
     * @param CacheProvider $cacheProvider Provides access to the cache.
     */
    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheData = array();
        $this->cacheProvider = $cacheProvider;
        $this->cacheProvider->setNamespace('wcf_');
    }

    /**
     * {@inheritdoc}
     */
    public function get(CacheBuilderInterface $cacheBuilder, $arrayIndex = '', array $parameters = array())
    {
        $cacheName = $this->getCacheName($cacheBuilder, $parameters);
        if (!isset($this->cacheData[$cacheName])) {
            // fetch cache or rebuild if missing
            $this->cacheData[$cacheName] = $this->cacheProvider->fetch($cacheName);
            if ($this->cacheData[$cacheName] === false) {
                // update cache
                $this->set($cacheBuilder, $parameters);
            }
        }

        if (!empty($arrayIndex)) {
            if (!isset($this->cacheData[$cacheName][$arrayIndex])) {
                throw new SystemException("array index '".$arrayIndex."' does not exist in cache resource");
            }

            return $this->cacheData[$cacheName][$arrayIndex];
        }

        return $this->cacheData[$cacheName];
    }

    /**
     * {@inheritdoc}
     */
    public function set(CacheBuilderInterface $cacheBuilder, array $parameters = array())
    {
        $cacheName = $this->getCacheName($cacheBuilder, $parameters);
        $this->cacheData[$cacheName] = $cacheBuilder->getData($parameters);
        $this->cacheProvider->save($cacheName, $this->cacheData[$cacheName], $cacheBuilder->getMaxLifetime());
    }

    /**
     * {@inheritdoc}
     */
    public function reset(CacheBuilderInterface $cacheBuilder, array $parameters = array())
    {
        $this->cacheProvider->delete($this->getCacheName($cacheBuilder, $parameters));
    }

    /**
     * {@inheritdoc}
     */
    public function resetAll()
    {
        $this->cacheProvider->flushAll();
    }

    /**
     * Returns cache index hash.
     *
     * @param array $parameters The parameters that should be considered.
     *
     * @return    string
     */
    public function getCacheIndex(array $parameters)
    {
        return sha1(serialize($this->orderParameters($parameters)));
    }

    /**
     * Returns the cache name.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface $cacheBuilder the cache builder
     * @param array                                                         $parameters   optional
     *
     * @return  string
     */
    private function getCacheName(CacheBuilderInterface $cacheBuilder, array $parameters = array())
    {
        $className = explode('\\', get_class($cacheBuilder));
        $vendor = array_shift($className);
        $bundle = '';
        $bundle1 = array_shift($className);
        $bundle2 = array_shift($className);
        if (strpos($bundle1, 'Bundle') !== false) {
            $bundle = $bundle1;
        } elseif (strpos($bundle2, 'Bundle') !== false) {
            $bundle = $bundle2;
        }
        $cacheName = str_replace('CacheBuilder', '', array_pop($className));
        if (!empty($parameters)) {
            $cacheName .= '-' . $this->getCacheIndex($parameters);
        }

        return mb_strtolower($vendor) . '_' . mb_strtolower($bundle) . '_' .
            mb_strtoupper(mb_substr($cacheName, 0, 1)).mb_substr($cacheName, 1);
    }

    /**
     * Unifies parameter order, numeric indices will be discarded.
     *
     * @param array $parameters The parameters that should be ordered.
     *
     * @return    array
     */
    protected function orderParameters($parameters)
    {
        if (!empty($parameters)) {
            array_multisort($parameters);
        }

        return $parameters;
    }
}
