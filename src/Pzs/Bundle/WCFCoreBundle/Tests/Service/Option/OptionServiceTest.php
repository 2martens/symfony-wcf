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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Service\Option;

use Pzs\Bundle\WCFCoreBundle\Service\Option\OptionService;

/**
 * Tests the option service.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class OptionServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The option service.
     * @var \Pzs\Bundle\WCFCoreBundle\Service\Option\OptionServiceInterface
     */
    private $optionService;
    
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $optionRepository = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $optionCategoryRepository = $this->getMockBuilder
            ('\Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $cacheService = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheService')
            ->disableOriginalConstructor()
            ->getMock();
        
        $option1 = $this->getMock('\Pzs\Bundle\WCFCoreBundle\Entity\Option');
        $option1->expects(parent::any())
            ->method('getOptionID')
            ->will(parent::returnValue(1));
        $option1->expects(parent::any())
            ->method('getOptionName')
            ->will(parent::returnValue('der_test'));
        $option1->expects(parent::any())
            ->method('getOptionValue')
            ->will(parent::returnValue(true));
        $option1->expects(parent::any())
            ->method('getOptionType')
            ->will(parent::returnValue('boolean'));
        
        $cacheService->expects(parent::once())
            ->method('get')
            ->will(parent::returnValue(array(
                    'der_test' => $option1
            )));
        
        $filesystem = $this->getMockBuilder('\Symfony\Component\Filesystem\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();
        $this->optionService = new OptionService($optionRepository, $optionCategoryRepository, $cacheService, 
            $filesystem);
    }

    /**
     * Tests the rebuildFile method.
     */
    public function testRebuildFile()
    {
        $filename = 'test.php';
        $output = $this->optionService->rebuildFile($filename);
        $expectedOutput = "<?php\n/**\n* generated at %TIME%\n*/\n";
        $expectedOutput .= "if (!defined('DER_TEST')) define('DER_TEST', 1);\n\n";
        parent::assertEquals($expectedOutput, $output);
    }
}
