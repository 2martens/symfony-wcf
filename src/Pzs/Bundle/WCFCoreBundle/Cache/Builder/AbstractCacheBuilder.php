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

namespace Pzs\Bundle\WCFCoreBundle\Cache\Builder;

/**
 * Provides default implementation for cache builders.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
abstract class AbstractCacheBuilder implements CacheBuilderInterface
{
    /**
     * maximum cache lifetime in seconds, '0' equals infinite
     * @var    integer
     */
    protected $maxLifetime;

    /**
     * Constructor.
     *
     * @internal    Sets maxLifetime to 0. If the cache should have a restricted validity, overwrite the
     * constructor and change the value.
     */
    public function __construct()
    {
        $this->maxLifetime = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxLifetime()
    {
        return $this->maxLifetime;
    }
}
