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

namespace Pzs\Bundle\WCFCoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="wcf1_language")
 * @ORM\Entity(repositoryClass="Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository")
 */
class Language
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="languageID", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $languageID;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="languageCode", type="string", length=20)
	 */
	private $languageCode;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="languageName", type="string", length=255)
	 */
	private $languageName;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="countryCode", type="string", length=10)
	 */
	private $countryCode;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="isDefault", type="boolean")
	 */
	private $isDefault;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="hasContent", type="boolean")
	 */
	private $hasContent;
	
	/**
	 * @var	\Doctrine\Common\Collections\ArrayCollection
	 * 
	 * @ORM\OneToMany(targetEntity="LanguageItem", mappedBy="language")
	 */
	private $languageItems;
	
	/**
	 * Initializes the Language entity.
	 */
	public function __construct()
	{
		$this->languageItems = new ArrayCollection();
	}
	
	/**
	 * Get language id.
	 *
	 * @return	integer
	 */
	public function getLanguageID()
	{
		return $this->languageID;
	}
	
	/**
	 * Set languageCode.
	 *
	 * @param	string	$languageCode
	 * @return	Language
	 */
	public function setLanguageCode($languageCode)
	{
		$this->languageCode = $languageCode;

		return $this;
	}
	
	/**
	 * Get languageCode.
	 *
	 * @return	string
	 */
	public function getLanguageCode()
	{
		return $this->languageCode;
	}
	
	/**
	 * Set languageName.
	 *
	 * @param    string    $languageName
	 * @return   Language
	 */
	public function setLanguageName($languageName)
	{
		$this->languageName = $languageName;

		return $this;
	}
	
	/**
	 * Get languageName.
	 *
	 * @return	string
	 */
	public function getLanguageName()
	{
		return $this->languageName;
	}
	
	/**
	 * Set countryCode.
	 *
	 * @param	string	$countryCode
	 * @return	Language
	 */
	public function setCountryCode($countryCode)
	{
		$this->countryCode = $countryCode;

		return $this;
	}
	
	/**
	 * Get countryCode.
	 *
	 * @return	string
	 */
	public function getCountryCode()
	{
		return $this->countryCode;
	}
	
	/**
	 * Set isDefault.
	 *
	 * @param	boolean	$isDefault
	 * @return	Language
	 */
	public function setIsDefault($isDefault)
	{
		$this->isDefault = $isDefault;

		return $this;
	}
	
	/**
	 * Get isDefault.
	 *
	 * @return	boolean
	 */
	public function getIsDefault()
	{
		return $this->isDefault;
	}
	
	/**
	 * Set hasContent.
	 *
	 * @param	boolean	$hasContent
	 * @return	Language
	 */
	public function setHasContent($hasContent)
	{
		$this->hasContent = $hasContent;

		return $this;
	}
	
	/**
	 * Get hasContent.
	 *
	 * @return	boolean
	 */
	public function getHasContent()
	{
		return $this->hasContent;
	}
	
    /**
     * Add languageItem.
     *
     * @param	\Pzs\Bundle\WCFCoreBundle\Entity\LanguageItem $languageItem
     * @return	Language
     */
    public function addLanguageItem(\Pzs\Bundle\WCFCoreBundle\Entity\LanguageItem $languageItem)
    {
        $this->languageItems->set($languageItem->getLanguageItem(), $languageItem);
    
        return $this;
    }
	
    /**
     * Remove languageItem.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Entity\LanguageItem $languageItem
     */
    public function removeLanguageItem(\Pzs\Bundle\WCFCoreBundle\Entity\LanguageItem $languageItem)
    {
        $this->languageItems->removeElement($languageItem);
    }
	
    /**
     * Get languageItems.
     *
     * @return	\Doctrine\Common\Collections\Collection 
     */
    public function getLanguageItems()
    {
        return $this->languageItems;
    }
}
