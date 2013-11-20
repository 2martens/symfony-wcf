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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Cache\Builder;

/**
 * Provides test cases common for all CacheBuilder.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
abstract class AbstractCacheBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The cache builder.
     * @var    \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface
     */
    protected $cacheBuilder;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $class = get_called_class();
        $classParts = explode('\\', $class);
        $className = array_pop($classParts);
        $newClassName = str_replace('CacheBuilderTest', 'CacheBuilder', $className);
        $newClass = 'Pzs\Bundle\WCFCoreBundle\Cache\Builder\\' . $newClassName;
        $this->cacheBuilder = $this->constructCacheBuilder($newClass);
    }

    /**
     * Tests the getMaxLifetime method.
     */
    public function testGetMaxLifetime()
    {
        parent::assertEquals(0, $this->cacheBuilder->getMaxLifetime());
    }

    /**
     * Calls the constructor of the CacheBuilder and returns the new object.
     *
     * @param string $newClass
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Cache\Builder\CacheBuilderInterface
     */
    abstract protected function constructCacheBuilder($newClass);
}
