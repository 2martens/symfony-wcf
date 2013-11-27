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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Cache\Builder;

/**
 * Tests the OptionCacheBuilder.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class OptionCacheBuilderTest extends AbstractCacheBuilderTest
{
    /**
     * {@inheritdoc}
     */
    protected function constructCacheBuilder($newClass)
    {
        $optionRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $optionRepository->expects(parent::any())
            ->method('findAll')
            ->will(parent::returnCallback(array($this, 'findAllOptionCallback')));
        $optionCategoryRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $optionCategoryRepository->expects(parent::any())
            ->method('findAll')
            ->will(parent::returnCallback(array($this, 'findAllOptionCategoryCallback')));

        return new $newClass($optionRepository, $optionCategoryRepository);
    }

    /**
     * Tests the getData method.
     */
    public function testGetData()
    {
        $result = $this->cacheBuilder->getData();
        // testing the options
        parent::assertEquals(1, $result['options'][1]->getOptionID());
        parent::assertEquals(2, $result['options'][2]->getOptionID());
        parent::assertEquals('der_test', $result['optionsByName']['der_test']->getOptionName());
        parent::assertEquals('ultimate_arsch', $result['optionsByName']['ultimate_arsch']->getOptionName());

        // testing the categories
        parent::assertEquals(1, $result['categories'][1]->getCategoryID());
        parent::assertEquals(2, $result['categories'][2]->getCategoryID());
        parent::assertEquals('user', $result['categoriesByName']['user']->getCategoryName());
        parent::assertEquals('system', $result['categoriesByName']['system']->getCategoryName());
    }

    // helper functions

    /**
     * Returns the result of the findAll option method.
     *
     * @return \Pzs\Bundle\WCFCoreBundle\Entity\Option[]
     */
    public function findAllOptionCallback()
    {
        $option1 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Option');
        $option1->expects(parent::any())
            ->method('getOptionID')
            ->will(parent::returnValue(1));
        $option1->expects(parent::any())
            ->method('getOptionName')
            ->will(parent::returnValue('der_test'));
        $option1->expects(parent::any())
            ->method('getOptionType')
            ->will(parent::returnValue('boolean'));
        $option1->expects(parent::any())
            ->method('getOptionValue')
            ->will(parent::returnValue(true));
        $option2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Option');
        $option2->expects(parent::any())
            ->method('getOptionID')
            ->will(parent::returnValue(2));
        $option2->expects(parent::any())
            ->method('getOptionName')
            ->will(parent::returnValue('ultimate_arsch'));
        $option1->expects(parent::any())
            ->method('getOptionType')
            ->will(parent::returnValue('integer'));
        $option1->expects(parent::any())
            ->method('getOptionValue')
            ->will(parent::returnValue(42));

        return array($option1, $option2);
    }

    /**
     * Returns the result of the findAll optionCategory method.
     *
     * @return \Pzs\Bundle\WCFCoreBundle\Entity\OptionCategory[]
     */
    public function findAllOptionCategoryCallback()
    {
        $optionCategory1 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\OptionCategory');
        $optionCategory1->expects(parent::any())
            ->method('getCategoryID')
            ->will(parent::returnValue(1));
        $optionCategory1->expects(parent::any())
            ->method('getCategoryName')
            ->will(parent::returnValue('user'));
        $optionCategory2 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\OptionCategory');
        $optionCategory2->expects(parent::any())
            ->method('getCategoryID')
            ->will(parent::returnValue(2));
        $optionCategory2->expects(parent::any())
            ->method('getCategoryName')
            ->will(parent::returnValue('system'));

        return array($optionCategory1, $optionCategory2);
    }
}
 
