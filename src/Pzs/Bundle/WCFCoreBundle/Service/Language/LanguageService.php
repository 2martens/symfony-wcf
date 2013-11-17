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

use Pzs\Bundle\WCFCoreBundle\Entity\Language;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository;

use Symfony\Component\Templating\EngineInterface;

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
	 * @param \Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository $languageRepository
	 * @param \Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository $languageCategoryRepository
	 */
	public function __construct(LanguageRepository $languageRepository, LanguageCategoryRepository $languageCategoryRepository)
	{
		$this->languageRepository = $languageRepository;
		$this->languageCategoryRepository = $languageCategoryRepository;
		$this->defaultLanguageID = 0;
		$this->currentLanguage = null;
	}
	
	/**
	 * 
	 */
	public function getLanguage($languageID)
	{
		return $this->languageRepository->find($languageID);
	}
	
	/**
	 * 
	 */
	public function getLanguageItem($languageItem)
	{
		$language = $this->getUserLanguage();
		$languageItems = $language->getLanguageItems();
		$languageItemValue = $languageItem;
		
		if ($languageItems->containsKey($languageItem))
		{
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
		if ($userLanguage === null)
		{
			$userLanguage = $this->getLanguage($this->defaultLanguageID);
		}
		return $userLanguage; 
	}
	
	/**
	 * 
	 */
	public function getLanguageByCode($languageCode)
	{
		return $this->languageRepository->findBy(array('languageCode' => $languageCode));
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
		return $this->languageCategoryRepository->findBy(array('languageCategory' => $categoryName));
	}
	
	/**
	 * 
	 */
	public function getCategoryByID($categoryID)
	{
		return $this->languageCategoryRepository->find($categoryID);
	}
	
	/**
	 * 
	 */
	public function getCategories()
	{
		return $this->languageCategoryRepository->findAll();
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
		return $this->languageRepository->findAll();
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
		if ($language === null)
		{
			$language = $this->getUserLanguage();
		}
		$languageCode = $language->getLanguageCode();
		return preg_replace('/-[a-z0-9]+/', '', $languageCode);
	}
}
