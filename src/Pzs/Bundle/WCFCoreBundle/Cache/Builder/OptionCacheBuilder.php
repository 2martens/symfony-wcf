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

use Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository;
use Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository;

/**
 * Caches the options.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class OptionCacheBuilder extends AbstractCacheBuilder
{
    /**
     * The option repository
     * @var \Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository
     */
    private $optionRepository;

    /**
     * The option category repository
     * @var \Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository
     */
    private $optionCategoryRepository;

    /**
     * Constructor.
     *
     * @param OptionRepository         $optionRepository         The option repository
     * @param OptionCategoryRepository $optionCategoryRepository The option category repository
     */
    public function __construct(OptionRepository $optionRepository, OptionCategoryRepository $optionCategoryRepository)
    {
        $this->optionRepository = $optionRepository;
        $this->optionCategoryRepository = $optionCategoryRepository;
    }

    /**
     * Returns the data that ought to be cached.
     *
     * @param array $parameters The optional parameters that can be given to the CacheBuilder
     *
     * @return array array('options' => array(optionID => option), 'optionsByName' => array(optionName => option), 'categories' => array(categoryID => category), 'categoriesByName' => array(categoryName => category))
     */
    public function getData(array $parameters = array())
    {
        $data = array(
            'options' => array(),
            'optionsByName' => array(),
            'categories' => array(),
            'categoriesByName' => array(),
        );

        /** @var $options \Pzs\Bundle\WCFCoreBundle\Entity\Option[] */
        $options = $this->optionRepository->findAll();

        foreach ($options as $option) {
            $data['options'][$option->getOptionID()] = $option;
            $data['optionsByName'][$option->getOptionName()] = $option;
        }

        $categories = $this->optionCategoryRepository->findAll();

        /** @var $categories \Pzs\Bundle\WCFCoreBundle\Entity\OptionCategory[] */
        foreach ($categories as $category) {
            $data['categories'][$category->getCategoryID()] = $category;
            $data['categoriesByName'][$category->getCategoryName()] = $category;
        }

        return $data;
    }
}
