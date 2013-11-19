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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Service\Cache;

use Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheService;

/**
 * Tests the cache service.
 *
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */
class CacheServiceTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * The cache service.
	 *
	 * @var \Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface
	 */
	private $cacheService;
	
	/**
	 * 
	 */
	public function setUp()
	{
		// TODO: add mocked CacheSource
		$cacheSource = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Cache\Source\TestCacheSource')
			->disableOriginalConstructor()
			->getMock();
		$cacheSource->expects(parent::any())
			->method('get')
			->will(parent::returnCallback(array($this, 'getCacheCallback')));
		$this->cacheService = new CacheService($cacheSource);
	}
	
	/**
	 * Tests the get and set method.
	 * 
	 * @expectedException	\Pzs\Bundle\WCFCoreBundle\Exception\SystemException
	 */
	public function testGetAndSet()
	{
		$cacheBuilder = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Cache\Builder\TestCacheBuilder')
			->disableOriginalConstructor()
			->getMock();
		$cacheBuilder->expects(parent::any())
			->method('getData')
			->will(parent::returnCallback(array($this, 'getDataCallback')));
		$this->cacheService->set($cacheBuilder);
		$result = $this->cacheService->get($cacheBuilder);
		parent::assertEquals(array('fuss' => 'alpha'), $result, 'For an existing cache, a wrong value has been returned.');

		$result = $this->cacheService->get($cacheBuilder, 'fuss');
		parent::assertEquals('alpha', $result, 'For an existing array index, a wrong value has been returned.');

		$this->cacheService->set($cacheBuilder, array('stupid' => true));
		$result = $this->cacheService->get($cacheBuilder, '', array('stupid' => true));
		parent::assertEquals(array('name' => 'alfonso'), $result, 'For an existing cache with the same parameters, a wrong value has been returned.');
		
		// test that an invalid array index does lead to a SystemException
		$this->cacheService->get($cacheBuilder, 'shucle');
	}

	/**
	 * Returns arrays depending on the input.
	 * 
	 * @return	string[]
	 */
	public function getCacheCallback()
	{
		$args = func_get_args();
		$cacheName = $args[0];
		if (strpos($cacheName, '-') !== false)
		{
			return array('name' => 'alfonso');
		}
		return null;//array('fuss' => 'alpha');
	}

	/**
	 * Returns arrays depending on the input.
	 * 
	 * @return	string[]
	 */
	public function getDataCallback()
	{
		$args = func_get_args();
		$parameters = $args[0];
		if (empty($parameters))
		{
			return array('fuss' => 'alpha');
		}
		return array('name' => 'alfonso');
	}
	
}
