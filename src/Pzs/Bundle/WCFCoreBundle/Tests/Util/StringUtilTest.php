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

namespace Pzs\Bundle\WCFCoreBundle\Tests\Util;
use Pzs\Bundle\WCFCoreBundle\Util\StringUtil;

/**
 * Tests the String Utilility.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class StringUtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The string utility
     * @var \Pzs\Bundle\WCFCoreBundle\Util\StringUtil
     */
    private $stringUtil;
    
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $languageService = $this->getMockBuilder('\Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageService')
            ->disableOriginalConstructor()
            ->getMock();
        $languageService->expects(parent::any())
            ->method('getLanguageItem')
            ->will(parent::returnCallback(array($this, 'languageServiceGetCallback')));
        
        $this->stringUtil = new StringUtil($languageService);
    }
    
    // -- helper functions

    /**
     * Returns a language item value depending on the input.
     * 
     * @return string
     */
    public function languageServiceGetCallback()
    {
        $args = func_get_args();
        $name = $args[0];
        
        if ($name == 'wcf.global.decimalPoint') {
            return '.';
        }
        elseif ($name == 'wcf.global.thousandsSeparator') {
            return ',';
        }
        
        return '';
    }
}
 
