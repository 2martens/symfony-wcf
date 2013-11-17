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
		$this->cacheService = new CacheService();
	}
	
	/**
	 * Tests the get and set method.
	 */
	public function testGetAndSet()
	{
		$this->cacheService->set('test', array('fuss' => 'alpha'));
		$result = $this->cacheService->get('test');
		parent::assertEquals(array('fuss' => 'alpha'), $result, 'For an existing cache, a wrong value has been returned.');
		
		$this->cacheService->set('test', array('name' => 'alfonso'), array('stupid' => true));
		$result = $this->cacheService->get('test', array('stupid' => true));
		parent::assertEquals(array('name' => 'alfonso'), $result, 'For an existing cache with the same parameters, a wrong value has been returned.');
	}
	
	/**
	 * Tests the isCacheExisting method.
	 */
	public function testIsCacheExisting()
	{
		$this->cacheService->set('test', array('1' => '2'));
		$result = $this->cacheService->isCacheExisting('test');
		parent::assertTrue($result, 'An existing cache has been marked as non-existant.');
		
		$result = $this->cacheService->isCacheExisting('bloed');
		parent::assertFalse($result, 'A non-existant cache has been marked as existing.');
	}
	
}
