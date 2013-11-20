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

namespace Pzs\Bundle\WCFCoreBundle\Service\Language;
use Pzs\Bundle\WCFCoreBundle\Entity\Language;

/**
 * Provides functionality for internationalization.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
interface LanguageServiceInterface
{
    /**
     * Returns language for given id or NULL if no such
     * language exists.
     *
     * @param integer $languageID
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\Language|NULL
     */
    public function getLanguage($languageID);

    /**
     * Returns the language item value of the language item with the given identifier in the current user language
     * or the given identifier if no such value is found.
     *
     * @param string $languageItem
     *
     * @return    string
     */
    public function getLanguageItem($languageItem);

    /**
     * Returns current user language.
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\Language
     */
    public function getUserLanguage();

    /**
     * Returns the language with the given language code or NULL
     * if no such language exists.
     *
     * @param string $languageCode
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\Language|NULL
     */
    public function getLanguageByCode($languageCode);

    /**
     * Returns true if a language category with the given
     * name exists.
     *
     * @param string $categoryName
     *
     * @return    boolean
     */
    public function isValidCategory($categoryName);

    /**
     * Returns the language category with the given name
     * or null if no such category exists.
     *
     * @param string $categoryName
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory|NULL
     */
    public function getCategory($categoryName);

    /**
     * Returns the language category with the given id
     * or null if no such category exists.
     *
     * @param integer $categoryID
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory|NULL
     */
    public function getCategoryByID($categoryID);

    /**
     * Returns a list of all available language categories.
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory[]
     */
    public function getCategories();

    /**
     * Returns the default language id.
     *
     * @return    integer
     */
    public function getDefaultLanguageID();

    /**
     * Returns a list of all available languages.
     *
     * @return    \Pzs\Bundle\WCFCoreBundle\Entity\Language[]
     */
    public function getLanguages();

    /**
     * Returns true if multilingualism is enabled.
     *
     * @return    boolean
     */
    public function isMultilingualismEnabled();

    /**
     * Sets the default language id.
     *
     * @param integer $languageID
     */
    public function setDefaultLanguage($languageID);

    /**
     * Returns the fixed language code of a given language.
     * If no language is given ($language === null), the current user language is used.
     *
     * The fixed language code is created by removing additional language identifier from the language code.
     * For example 'de-informal' becomes 'de'.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Entity\Language $language
     *
     * @return    string
     */
    public function getFixedLanguageCode(Language $language = null);
}
