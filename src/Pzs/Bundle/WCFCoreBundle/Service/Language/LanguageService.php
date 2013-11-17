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

use Symfony\Component\Templating\EngineInterface;
use Pzs\Bundle\WCFCoreBundle\Entity\Language;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository;

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
	// TODO: Implement methods.
	
	/**
	 * Constructor.
	 * 
	 * @param \Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository $repository
	 */
	public function __construct(LanguageRepository $repository)
	{
		
	}
	
	/**
	 * 
	 */
	public function getLanguage($languageID)
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function getLanguageItem($languageItem)
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function getUserLanguage()
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function getLanguageByCode($languageCode)
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function isValidCategory($categoryName)
	{
		return false;
	}
	
	/**
	 * 
	 */
	public function getCategory($categoryName)
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function getCategoryByID($categoryID)
	{
		return null;
	}
	
	/**
	 * 
	 */
	public function getCategories()
	{
		return array();
	}
	
	/**
	 * 
	 */
	public function getDefaultLanguageID()
	{
		return 0;
	}
	
	/**
	 * 
	 */
	public function getLanguages()
	{
		return array();
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
		
	}
	
	/**
	 * 
	 */
	public function getFixedLanguageCode(Language $language = null)
	{
		return '';
	}
}
