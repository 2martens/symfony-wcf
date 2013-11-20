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

namespace Pzs\Bundle\WCFCoreBundle\Cache\Builder;

use Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository;
use Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository;

/**
 * Implementation for languages.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class LanguageCacheBuilder extends AbstractCacheBuilder
{
    /**
     * The language repository.
     * @var    \Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository
     */
    private $languageRepository;

    /**
     * The language category repository.
     * @var    \Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository
     */
    private $languageCategoryRepository;

    /**
     * Constructor.
     *
     * @param \Pzs\Bundle\WCFCoreBundle\Repository\LanguageRepository         $languageRepository
     * @param \Pzs\Bundle\WCFCoreBundle\Repository\LanguageCategoryRepository $languageCategoryRepository
     */
    public function __construct(LanguageRepository $languageRepository,
                                LanguageCategoryRepository $languageCategoryRepository)
    {
        parent::__construct();
        $this->languageRepository = $languageRepository;
        $this->languageCategoryRepository = $languageCategoryRepository;
    }

    /**
     * Returns the data that ought to be cached.
     *
     * @param array $parameters
     *
     * @return    array array('languages' => array(id => language), 'languagesByCode' => array(code => language), 'categories' => array(id => languageCategory), 'categoriesByName' => array(name => languageCategory))
     */
    public function getData(array $parameters = array())
    {
        $data = array(
            'languages' => array(),
            'languagesByCode' => array(),
            'categories' => array(),
            'categoriesByName' => array()
        );
        /** @var $languages \Pzs\Bundle\WCFCoreBundle\Entity\Language[] */
        $languages = $this->languageRepository->findAll();

        foreach ($languages as $language) {
            $data['languages'][$language->getLanguageID()] = $language;
            $data['languagesByCode'][$language->getLanguageCode()] = $language;
        }

        /** @var $categories \Pzs\Bundle\WCFCoreBundle\Entity\LanguageCategory[] */
        $categories = $this->languageCategoryRepository->findAll();
        foreach ($categories as $category) {
            $data['categories'][$category->getLanguageCategoryID()] = $category;
            $data['categoriesByName'][$category->getLanguageCategory()] = $category;
        }

        return $data;
    }
}
