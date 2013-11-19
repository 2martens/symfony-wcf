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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Cache\Builder;

/**
 * Tests the LanguageCacheBuilder.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */
class LanguageCacheBuilderTest extends AbstractCacheBuilderTest
{
	/**
	 *
	 */
	protected function constructCacheBuilder($newClass)
	{
		$languageRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository')
			->disableOriginalConstructor()
			->getMock();
		$languageRepository->expects(parent::any())
			->method('findAll')
			->will(parent::returnCallback(array($this, 'findAllLanguageCallback')));
		$languageCategoryRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository')
			->disableOriginalConstructor()
			->getMock();
		$languageCategoryRepository->expects(parent::any())
			->method('findAll')
			->will(parent::returnCallback(array($this, 'findAllLanguageCategoryCallback')));
		return new $newClass($languageRepository, $languageCategoryRepository);
	}

	/**
	 * Tests the getData method.
	 */
	public function testGetData()
	{
		$result = $this->cacheBuilder->getData();
		// testing the languages
		parent::assertEquals(1, $result['languages'][1]->getLanguageID());
		parent::assertEquals(2, $result['languages'][2]->getLanguageID());
		parent::assertEquals('de', $result['languagesByCode']['de']->getLanguageCode());
		parent::assertEquals('en', $result['languagesByCode']['en']->getLanguageCode());

		// testing the categories
		parent::assertEquals(1, $result['categories'][1]->getLanguageCategoryID());
		parent::assertEquals(2, $result['categories'][2]->getLanguageCategoryID());
		parent::assertEquals('wcf.form', $result['categoriesByName']['wcf.form']->getLanguageCategory());
		parent::assertEquals('wcf.global', $result['categoriesByName']['wcf.global']->getLanguageCategory());
	}

	// helper functions

	/**
	 * Returns the result of the findAll language method.
	 */
	public function findAllLanguageCallback()
	{
		$language1 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language1->expects(parent::any())
			->method('getLanguageID')
			->will(parent::returnValue(1));
		$language1->expects(parent::any())
			->method('getLanguageCode')
			->will(parent::returnValue('de'));
		$language2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language2->expects(parent::any())
			->method('getLanguageID')
			->will(parent::returnValue(2));
		$language2->expects(parent::any())
			->method('getLanguageCode')
			->will(parent::returnValue('en'));

		return array($language1, $language2);
	}

	/**
	 * Returns the result of the findAll languageCategory method.
	 */
	public function findAllLanguageCategoryCallback()
	{
		$languageCategory1 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
		$languageCategory1->expects(parent::any())
			->method('getLanguageCategoryID')
			->will(parent::returnValue(1));
		$languageCategory1->expects(parent::any())
			->method('getLanguageCategory')
			->will(parent::returnValue('wcf.form'));
		$languageCategory2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
		$languageCategory2->expects(parent::any())
			->method('getLanguageCategoryID')
			->will(parent::returnValue(2));
		$languageCategory2->expects(parent::any())
			->method('getLanguageCategory')
			->will(parent::returnValue('wcf.global'));

		return array($languageCategory1, $languageCategory2);
	}
}
