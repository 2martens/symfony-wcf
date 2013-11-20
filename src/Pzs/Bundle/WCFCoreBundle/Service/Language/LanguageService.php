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

namespace Pzs\Bundle\WCFCoreBundle\Service\Language;

use Pzs\Bundle\WCFCoreBundle\Cache\Builder\LanguageCacheBuilder;
use Pzs\Bundle\WCFCoreBundle\Entity\Language;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository;
use Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface;

/**
 * Manages the languages.
 * 
 * @author		Jim Martens
 * @copyright	2013 Jim Martens
 * @license		http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 * @package		pzs/wcf-core-bundle
 */
class LanguageService implements LanguageServiceInterface
{
	/**
	 * The language repository.
	 * @var \Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository
	 */
	private $languageRepository;

	/**
	 * The language category repository.
	 * @var \Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository
	 */
	private $languageCategoryRepository;

	/**
	 * The cache service.
	 * @var	\Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface
	 */
	private $cacheService;

	/**
	 * The cached language data.
	 * @var	array
	 */
	private $cacheData;

	/**
	 * The default language id.
	 * @var integer
	 */
	private $defaultLanguageID;

	/**
	 * The current user language.
	 * If no user is available, it contains null.
	 * @var \Pzs\Bundle\WCFCoreBundle\Entity\Language|null
	 */
	private $currentLanguage;

	/**
	 * Constructor.
	 * 
	 * @param	\Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository			$languageRepository
	 * @param	\Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository	$languageCategoryRepository
	 * @param	\Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface	$cacheService
	 */
	public function __construct(LanguageRepository $languageRepository, 
								LanguageCategoryRepository $languageCategoryRepository,
								CacheServiceInterface $cacheService)
	{
		// initialization
		$this->languageRepository = $languageRepository;
		$this->languageCategoryRepository = $languageCategoryRepository;
		$this->cacheService = $cacheService;
		$this->defaultLanguageID = 0;
		$this->currentLanguage = null;
		$this->cacheData = array();

		// retrieve cache data
		$cacheBuilder = new LanguageCacheBuilder($this->languageRepository, $this->languageCategoryRepository);
		$this->cacheData = $this->cacheService->get($cacheBuilder);
	}

	/**
	 * 
	 */
	public function getLanguage($languageID)
	{
		$language = null;
		if (isset($this->cacheData['languages'][$languageID])) {
			$language = $this->cacheData['languages'][$languageID];
		} else {
			$this->cacheData['languages'][$languageID] = $language = $this->languageRepository->find($languageID);
		}

		return $language;
	}

	/**
	 * 
	 */
	public function getLanguageItem($languageItem)
	{
		$language = $this->getUserLanguage();
		$languageItems = $language->getLanguageItems();
		$languageItemValue = $languageItem;

		if ($languageItems->containsKey($languageItem)) {
			$languageItemValue = $languageItems->get($languageItem)->getLanguageItemValue();
		}

		return $languageItemValue;
	}

	/**
	 * 
	 */
	public function getUserLanguage()
	{
		$userLanguage = $this->currentLanguage;
		if ($userLanguage === null) {
			$userLanguage = $this->getLanguage($this->defaultLanguageID);
		}

		return $userLanguage; 
	}

	/**
	 * 
	 */
	public function getLanguageByCode($languageCode)
	{
		$language = null;
		if (isset($this->cacheData['languagesByCode'][$languageCode])) {
			$language = $this->cacheData['languagesByCode'][$languageCode];
		} else {
			$this->cacheData['languagesByCode'][$languageCode] = $language = $this->languageRepository->findBy(array('languageCode' => $languageCode));
		}

		return $language;
	}

	/**
	 * 
	 */
	public function isValidCategory($categoryName)
	{
		$category = $this->getCategory($categoryName);

		return $category !== null;
	}

	/**
	 * 
	 */
	public function getCategory($categoryName)
	{
		$category = null;
		if (isset($this->cacheData['categoriesByName'][$categoryName])) {
			$category = $this->cacheData['categoriesByName'][$categoryName];
		} else {
			$this->cacheData['categoriesByName'][$categoryName] = $category = $this->languageCategoryRepository->findBy(array('languageCategory' => $categoryName));
		}

		return $category;
	}

	/**
	 * 
	 */
	public function getCategoryByID($categoryID)
	{
		$category = null;
		if (isset($this->cacheData['categories'][$categoryID])) {
			$category = $this->cacheData['categories'][$categoryID];
		} else {
			$this->cacheData['categories'][$categoryID] = $category = $this->languageCategoryRepository->find($categoryID);
		}

		return $category;
	}

	/**
	 * 
	 */
	public function getCategories()
	{
		$categories = $this->cacheData['categories'];
		if (empty($categories)) {
			$this->cacheData['categories'] = $categories = $this->languageCategoryRepository->findAll();
		}

		return $categories;
	}

	/**
	 * 
	 */
	public function getDefaultLanguageID()
	{
		return $this->defaultLanguageID;
	}

	/**
	 * 
	 */
	public function getLanguages()
	{
		$languages = $this->cacheData['languages'];
		if (empty($languages)) {
			$this->cacheData['languages'] = $languages = $this->languageRepository->findAll();
		}

		return $languages;
	}

	/**
	 * 
	 */
	public function isMultilingualismEnabled()
	{
		return false;
	}

	/**
	 * 
	 */
	public function setDefaultLanguage($languageID)
	{
		$this->defaultLanguageID = intval($languageID);
	}

	/**
	 * 
	 */
	public function getFixedLanguageCode(Language $language = null)
	{
		if ($language === null) {
			$language = $this->getUserLanguage();
		}
		$languageCode = $language->getLanguageCode();

		return preg_replace('/-[a-z0-9]+/', '', $languageCode);
	}
}
