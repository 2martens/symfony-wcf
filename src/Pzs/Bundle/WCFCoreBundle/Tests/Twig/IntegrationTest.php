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
 * @author      Jim Martens
 * @copyright   2011-2012 Jim Martens
 * @license     http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package     pzs/wcf-core-bundle
 */

namespace Pzs\Bundle\WCFCoreBundle\Tests\Twig;

use Pzs\Bundle\WCFCoreBundle\Twig\WCFCoreExtension;

/**
 * Tests the WCFTwigExtension.
 *
 * @author      Jim Martens
 * @copyright   2013 Jim Martens
 * @license     http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package     pzs/wcf-core-bundle
 */
class WCFTwigIntegrationTest extends \Twig_Test_IntegrationTestCase
{
	/**
	 * Returns the tested extensions.
	 * 
	 * @return	array
	 */
	public function getExtensions()
	{
		$languageService = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageService')
			->disableOriginalConstructor()
			->getMock();
		$languageService->expects(parent::once())
			->method('getLanguageItem')
			->will(parent::returnValue('hello world'));

		return array(
			new WCFCoreExtension($languageService),
		);
	}

	/**
	 * Returns the fixtures dir.
	 * 
	 * @return	string
	 */
	public function getFixturesDir()
	{
		return dirname(__FILE__).'/Fixtures/';
	}
}
