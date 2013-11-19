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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Service\Language;

use Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageService;

/**
 * Tests the language service.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */
class LanguageServiceTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * The language service.
	 * 
	 * @var \Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageServiceInterface
	 */
	private $languageService;
	
	/**
	 * 
	 */
	public function setUp()
	{
		$languageRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository')
			->disableOriginalConstructor()
			->getMock();
		$languageRepository->expects(parent::any())
			->method('find')
			->will(parent::returnCallback(array($this, 'findLanguageCallback')));
		$languageRepository->expects(parent::any())
			->method('findBy')
			->will(parent::returnCallback(array($this, 'findByLanguageCallback')));
		$languageRepository->expects(parent::any())
			->method('findAll')
			->will(parent::returnCallback(array($this, 'findAllLanguageCallback')));
		
		$languageCategoryRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository')
			->disableOriginalConstructor()
			->getMock();
		$languageCategoryRepository->expects(parent::any())
			->method('find')
			->will(parent::returnCallback(array($this, 'findLanguageCategoryCallback')));
		$languageCategoryRepository->expects(parent::any())
			->method('findBy')
			->will(parent::returnCallback(array($this, 'findByLanguageCategoryCallback')));
		$languageCategoryRepository->expects(parent::any())
			->method('findAll')
			->will(parent::returnCallback(array($this, 'findAllLanguageCategoryCallback')));

		$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language->expects(parent::any())
			->method('getLanguageID')
			->will(parent::returnValue(1));
		$language->expects(parent::any())
			->method('getLanguageCode')
			->will(parent::returnValue('de'));
		$language->expects(parent::any())
			->method('getLanguageItems')
			->will(parent::returnCallback(array($this, 'getLanguageItemsCallback')));;
		$language2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language2->expects(parent::any())
			->method('getLanguageID')
			->will(parent::returnValue(2));
		$language2->expects(parent::any())
			->method('getLanguageItems')
			->will(parent::returnCallback(array($this, 'getLanguageItemsCallback')));;
		$language2->expects(parent::any())
			->method('getLanguageCode')
			->will(parent::returnValue('en'));

		$cacheService = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheService')
			->disableOriginalConstructor()
			->getMock();
		$cacheService->expects(parent::any())
			->method('get')
			->will(parent::returnValue(array(
				'languages' => array(
					1 => $language,
					2 => $language2
				),
				'languagesByCode' => array(
					'de' => $language,
					'en' => $language2
				),
				'categories' => array()
			)));
		
		$this->languageService = new LanguageService($languageRepository, 
		                                             $languageCategoryRepository, 
		                                             $cacheService);
		$this->languageService->setDefaultLanguage(2);
	}
	
	/**
	 * Tests the getLanguage method.
	 */
	public function testGetLanguage()
	{
		$actualLanguage1 = $this->languageService->getLanguage(1);
		parent::assertEquals(1, $actualLanguage1->getLanguageID(), 'For an existing ID, a wrong language has been returned.');
		
		$actualLanguage2 = $this->languageService->getLanguage(3);
		parent::assertNull($actualLanguage2, 'For an invalid language id, a value not equal to null has been returned.');
	}
	
	/**
	 * Tests the getLanguageByCode method.
	 */
	public function testGetLanguageByCode()
	{
		$actualLanguage1 = $this->languageService->getLanguageByCode('de');
		parent::assertEquals('de', $actualLanguage1->getLanguageCode(), 'For an existing language code, a wrong language has been returned.');
		
		$actualLanguage2 = $this->languageService->getLanguageByCode('js');
		parent::assertNull($actualLanguage2, 'For an invalid language code, a value not equal to null has been returned.');
	}
	
	/**
	 * Tests the getLanguages method.
	 */
	public function testGetLanguages()
	{
		$languages = $this->languageService->getLanguages();
		
		parent::assertCount(2, $languages, 'The result array contains more or less entries than languages exist.');
		parent::assertContainsOnlyInstancesOf('\Pzs\Bundle\WCFCoreBundle\Entity\Language', $languages, 'The result array does contain elements that are not languages.');
	
		$containsAllLanguages = false;
		$contains1 = false;
		$contains2 = false;
		$containsOnlyExistingLanguages = true;
		foreach ($languages as $language)
		{
			$id = $language->getLanguageID();
			if ($id == 1)
			{
				$contains1 = true;
			}
			elseif ($id == 2)
			{
				$contains2 = true;
			}
			else
			{
				$containsOnlyExistingLanguages = false;
			}
		}
		$containsAllLanguages = $contains1 && $contains2 && $containsOnlyExistingLanguages;
	
		parent::assertTrue($containsAllLanguages, 'The result array contains either not all or more languages than actually exist.');
	}
	
	/**
	 * Tests the setDefaultLanguageID method.
	 */
	public function testSetDefaultLanguageID()
	{
		$this->languageService->setDefaultLanguage(1);
		parent::assertEquals(1, $this->languageService->getDefaultLanguageID(), 'The default language id hasn\'t been returned.');
	}
	
	/**
	 * Tests the getDefaultLanguageID method.
	 */
	public function testGetDefaultLanguageID()
	{
		parent::assertEquals(2, $this->languageService->getDefaultLanguageID(), 'The default language id hasn\'t been returned.');
	}
	
	/**
	 * Tests the getCategory method.
	 */
	public function testGetCategory()
	{
		$actualLanguageCategory1 = $this->languageService->getCategory('wcf.global');
		parent::assertEquals('wcf.global', $actualLanguageCategory1->getLanguageCategory(), 'For an existing category name, a wrong language category has been returned.');
	
		$actualLanguageCategory2 = $this->languageService->getCategory('wcf.humbug');
		parent::assertNull($actualLanguageCategory2, 'For an invalid language category name, a value not equal to null has been returned.');
	}
	
	/**
	 * Tests the getCategoryByID method.
	 */
	public function testGetCategoryByID()
	{
		$actualLanguageCategory1 = $this->languageService->getCategoryByID(1);
		parent::assertEquals(1, $actualLanguageCategory1->getLanguageCategoryID(), 'For an existing ID, a wrong language has been returned.');
	
		$actualLanguageCategory2 = $this->languageService->getCategoryByID(3);
		parent::assertNull($actualLanguageCategory2, 'For an invalid id, a value not equal to null has been returned.');
	}
	
	/**
	 * Tests the isValidCategory method.
	 */
	public function testIsValidCategory()
	{
		parent::assertTrue($this->languageService->isValidCategory('wcf.global'), 'For a valid category, a value not equal to true has been returned.');
		parent::assertFalse($this->languageService->isValidCategory('wcf.humbug'), 'For an invalid category, a value not equal to false has been returned.');
	}
	
	/**
	 * Tests the getCategories method.
	 */
	public function testGetCategories()
	{
		$categories = $this->languageService->getCategories();
		parent::assertCount(2, $categories, 'The result array contains more or less entries than categories exist.');
		parent::assertContainsOnlyInstancesOf('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory', $categories, 'The result array does contain elements that are not language categories.');
		
		$containsAllCategories = false;
		$contains1 = false;
		$contains2 = false;
		$containsOnlyExistingCategories = true;
		foreach ($categories as $category)
		{
			$id = $category->getLanguageCategoryID();
			if ($id == 1)
			{
				$contains1 = true;
			}
			elseif ($id == 2)
			{
				$contains2 = true;
			}
			else
			{
				$containsOnlyExistingCategories = false;
			}
		}
		$containsAllCategories = $contains1 && $contains2 && $containsOnlyExistingCategories;
		
		parent::assertTrue($containsAllCategories, 'The result array contains either not all or more categories than actually exist.');
	}
	
	/**
	 * Tests the fixLanguageCode method.
	 */
	public function testGetFixedLanguageCode()
	{
		$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language->expects(parent::once())
			->method('getLanguageCode')
			->will(parent::returnValue('de-informal'));
		parent::assertEquals('de', $this->languageService->getFixedLanguageCode($language), 'The returned language code doesn\'t fit the expected one.');
		
		$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language->expects(parent::once())
			->method('getLanguageCode')
			->will(parent::returnValue('en'));
		parent::assertEquals('en', $this->languageService->getFixedLanguageCode($language), 'The returned language code doesn\'t fit the expected one.');
		// if no parameter is given, the user language should be used, which in this case is the default language
		parent::assertEquals('en', $this->languageService->getFixedLanguageCode(), 'The returned language code doesn\'t fit the expected one.');
	}
	
	/**
	 * Tests the getLanguageItem method.
	 */
	public function testGetLanguageItem()
	{
		$languageItemValue = $this->languageService->getLanguageItem('wcf.global.test');
		parent::assertEquals('testAlpha', $languageItemValue, 'The returned language item value is not correct.');
	}
	
	/**
	 * Tests the getUserLanguage method.
	 */
	public function testGetUserLanguage()
	{
		// as there is no user available, the default language should be returned
		$language = $this->languageService->getUserLanguage();
		parent::assertEquals(2, $language->getLanguageID(), 'The returned user language is not the default language.');
	}
	
	// TODO: implement test for isMultilingualismEnabled
	
	// ----- helper functions ----//
	
	/**
	 * Return language mocks or null depending on the input.
	 * This is a callback for the find method.
	 * 
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findLanguageCallback()
	{
		$args = func_get_args();
		$id = $args[0];
		if ($id == 1)
		{
			$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
			$language->expects(parent::once())
				->method('getLanguageID')
				->will(parent::returnValue(1));
			return $language;
		}
		elseif ($id == 2)
		{
			$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
			$language->expects(parent::any())
				->method('getLanguageID')
				->will(parent::returnValue(2));
			$language->expects(parent::any())
				->method('getLanguageItems')
				->will(parent::returnCallback(array($this, 'getLanguageItemsCallback')));;
			$language->expects(parent::any())
				->method('getLanguageCode')
				->will(parent::returnValue('en'));
			return $language;
		}
		else
		{
			return null;
		}
	}
	
	
	/**
	 * Return language mocks or null depending on the input.
	 * This is a method for the findBy method.
	 *
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findByLanguageCallback()
	{
		$args = func_get_args();
		$languageCode = $args[0]['languageCode'];
		if ($languageCode == 'de')
		{
			$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
			$language->expects(parent::once())
				->method('getLanguageCode')
				->will(parent::returnValue('de'));
			return $language;
		}
		elseif ($languageCode == 'en')
		{
			$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
			$language->expects(parent::once())
				->method('getLanguageCode')
				->will(parent::returnValue('en'));
			return $language;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * Return language mocks or null depending on the input.
	 * This is a method for the findAll method.
	 *
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findAllLanguageCallback()
	{
		$language = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language->expects(parent::once())
			->method('getLanguageID')
			->will(parent::returnValue(1));
		$language2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Language');
		$language2->expects(parent::once())
			->method('getLanguageID')
			->will(parent::returnValue(2));
		return array($language, $language2);
	}
	
	
	/**
	 * Return language category mocks or null depending on the input.
	 * This is a callback for the find method.
	 *
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findLanguageCategoryCallback()
	{
		$args = func_get_args();
		$id = $args[0];
		if ($id == 1)
		{
			$languageCategory = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
			$languageCategory->expects(parent::once())
				->method('getLanguageCategoryID')
				->will(parent::returnValue(1));
			return $languageCategory;
		}
		elseif ($id == 2)
		{
			$languageCategory = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
			$languageCategory->expects(parent::once())
				->method('getLanguageCategoryID')
				->will(parent::returnValue(2));
			return $languageCategory;
		}
		else
		{
			return null;
		}
	}
	
	
	/**
	 * Return language category mocks or null depending on the input.
	 * This is a method for the findBy method.
	 *
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findByLanguageCategoryCallback()
	{
		$args = func_get_args();
		$languageCategory = $args[0]['languageCategory'];
		if ($languageCategory == 'wcf.global')
		{
			$languageCategory = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
			$languageCategory->expects(parent::any())
				->method('getLanguageCategory')
				->will(parent::returnValue('wcf.global'));
			return $languageCategory;
		}
		elseif ($languageCategory == 'wcf.acp')
		{
			$languageCategory = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
			$languageCategory->expects(parent::any())
				->method('getLanguageCategory')
				->will(parent::returnValue('wcf.acp'));
			return $languageCategory;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * Return language category mocks or null depending on the input.
	 * This is a method for the findAll method.
	 *
	 * @return	 \PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function findAllLanguageCategoryCallback()
	{
		$languageCategory = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
		$languageCategory->expects(parent::once())
			->method('getLanguageCategoryID')
			->will(parent::returnValue(1));
		$languageCategory2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory');
		$languageCategory2->expects(parent::once())
			->method('getLanguageCategoryID')
			->will(parent::returnValue(2));
		return array($languageCategory, $languageCategory2);
	}
	
	/**
	 * Return doctrine collection mock or null depending on the input.
	 * This is a method for the getLanguageItems method.
	 * 
	 * @return	\PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function getLanguageItemsCallback()
	{
		$collection = $this->getMock('\Doctrine\Common\Collections\Collection');
		$collection->expects(parent::once())
			->method('get')
			->will(parent::returnCallback(array($this, 'getLanguageItemCallback')));
		$collection->expects(parent::once())
			->method('containsKey')
			->will(parent::returnValue(true));
		return $collection;
	}
	
	/**
	 * Returns language item mocks or null depending on the input.
	 * This is a method for the getLanguageItem method.
	 * 
	 * @return	\PHPUnit_Framework_MockObject_MockObject|NULL
	 */
	public function getLanguageItemCallback()
	{
		$args = func_get_args();
		$languageItem = $args[0];
		if ($languageItem == 'wcf.global.test')
		{
			$languageItem = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\LanguageItem');
			$languageItem->expects(parent::once())
				->method('getLanguageItemValue')
				->will(parent::returnValue('testAlpha'));
			return $languageItem;
		}
		else
		{
			return null;
		}
	}
	
}
