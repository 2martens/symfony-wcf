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

namespace Pzs\Bundle\WCFCoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LanguageCategory
 *
 * @ORM\Table(name="wcf1_language_category")
 * @ORM\Entity(repositoryClass="Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository")
 */
class LanguageCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="languageCategoryID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $languageCategoryID;

    /**
     * @var string
     *
     * @ORM\Column(name="languageCategory", type="string", length=255)
     */
    private $languageCategory;

    /**
     * @var    \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="LanguageItem", mappedBy="languageCategory")
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
     * Get language category id.
     *
     * @return    integer
     */
    public function getLanguageCategoryID()
    {
        return $this->languageCategoryID;
    }

    /**
     * Set languageCategory.
     *
     * @param string $languageCategory The name this category should have
     *
     * @return    LanguageCategory
     */
    public function setLanguageCategory($languageCategory)
    {
        $this->languageCategory = $languageCategory;

        return $this;
    }

    /**
     * Get languageCategory.
     *
     * @return    string
     */
    public function getLanguageCategory()
    {
        return $this->languageCategory;
    }

    /**
     * Add languageItem.
     *
     * @param LanguageItem $languageItem The language item that should be added
     *
     * @return    LanguageCategory
     */
    public function addLanguageItem(LanguageItem $languageItem)
    {
        $this->languageItems->set($languageItem->getLanguageItem(), $languageItem);

        return $this;
    }

    /**
     * Remove languageItem.
     *
     * @param LanguageItem $languageItem The language item that should be removed
     */
    public function removeLanguageItem(LanguageItem $languageItem)
    {
        $this->languageItems->removeElement($languageItem);
    }

    /**
     * Get languageItems.
     *
     * @return    \Doctrine\Common\Collections\Collection
     */
    public function getLanguageItems()
    {
        return $this->languageItems;
    }
}
