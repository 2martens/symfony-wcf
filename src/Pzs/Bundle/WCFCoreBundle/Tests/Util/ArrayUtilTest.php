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
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */

namespace Pzs\Bundle\WCFCoreBundle\Tests\Util;
use Pzs\Bundle\WCFCoreBundle\Util\ArrayUtil;

/**
 * Tests the Array Utility.
 *
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class ArrayUtilTest extends \PHPUnit_Framework_TestCase {

    /**
     * Tests the trim method.
     */
    public function testTrim()
    {
        $test = array(
            'Hallo ',
            'Hello hallo ',
            ' Rykjavik 
            ',
            ' '
        );
        $expectedWithEmpty = array(
            'Hallo',
            'Hello hallo',
            'Rykjavik',
            ''
        );
        $expectedWithoutEmpty = array(
            'Hallo',
            'Hello hallo',
            'Rykjavik'
        );
        
        parent::assertEquals($expectedWithoutEmpty, ArrayUtil::trim($test));
        parent::assertEquals($expectedWithEmpty, ArrayUtil::trim($test, false));
    }

    /**
     * Tests the toIntegerArray method.
     */
    public function testToIntegerArray()
    {
        $test = array(
            12.0,
            14,
            '13',
            '12.9'
        );
        $expected = array(
            12,
            14,
            13,
            12
        );
        
        parent::assertEquals($expected, ArrayUtil::toIntegerArray($test));
    }

    /**
     * Tests the encodeHTML method.
     */
    public function testEncodeHTML()
    {
        $test = array(
            '<p>Hallo</p>',
            '<![CDATA[Hello hallo]]>',
            '"<p>" Hallo "</p>'
        );
        $expected = array(
            '&lt;p&gt;Hallo&lt;/p&gt;',
            '&lt;![CDATA[Hello hallo]]&gt;',
            '&quot;&lt;p&gt;&quot; Hallo &quot;&lt;/p&gt;'
        );
        
        parent::assertEquals($expected, ArrayUtil::encodeHTML($test));
    }

    /**
     * Tests the stripslashes method.
     */
    public function testStripslashes()
    {
        $test = array(
            'Hallo\\Hello\\Bonjour/',
            'Tschüss\Bye\Salut/'
        );
        $expected = array(
            'HalloHelloBonjour/',
            'TschüssByeSalut/'
        );
        
        parent::assertEquals($expected, ArrayUtil::stripslashes($test));
    }

    /**
     * Tests the appendSuffix method.
     */
    public function testAppendSuffix()
    {
        $suffix = 'HELO';
        $test = array(
            'Hallo Mustang',
            'Hello Asshole',
            'Stupid Monkey'
        );
        $expected = array(
            'Hallo Mustang'.$suffix,
            'Hello Asshole'.$suffix,
            'Stupid Monkey'.$suffix
        );
        
        parent::assertEquals($expected, ArrayUtil::appendSuffix($test, $suffix));
    }

    /**
     * Tests the unifyNewlines method.
     */
    public function testUnifyNewlines()
    {
        $test = array(
            'Windows'."\r\n",
            'Linux, OS X'."\n",
            'Old Mac'."\r"
        );
        $expected = array(
            'Windows'."\n",
            'Linux, OS X'."\n",
            'Old Mac'."\n"
        );
        
        parent::assertEquals($expected, ArrayUtil::unifyNewlines($test));
    }

    /**
     * Tests the convertEncoding method.
     */
    public function testConvertEncoding()
    {
        $testUTF8ToISO = array(
            'Gräfin Darß Blüte Böhmisch',
            array(
                'äöüß'
            ),
            'Hello Yourth Faithfully'
        );
        
        $testISOToUTF8 = array(
            utf8_decode('Hello Miss Marple'),
            utf8_decode('SC SQ42 BDSSE')
        );
        
        $expectedUTF8ToISO = array(
            utf8_decode('Gräfin Darß Blüte Böhmisch'),
            array(
                utf8_decode('äöüß')
            ),
            utf8_decode('Hello Yourth Faithfully')
        );
        
        $expectedISOToUTF8 = array(
            'Hello Miss Marple',
            'SC SQ42 BDSSE'
        );
        
        parent::assertEquals($expectedISOToUTF8, ArrayUtil::convertEncoding('ISO-8859-1', 'UTF-8', $testISOToUTF8));
        parent::assertEquals($expectedUTF8ToISO, ArrayUtil::convertEncoding('UTF-8', 'ISO-8859-1', $testUTF8ToISO));        
    }

    /**
     * Tests the compare method.
     */
    public function testCompare()
    {
        $array1 = array(
            0 => 'One',
            1 =>'Two',
            2 => 3,
            3 => 4
        );
        $array2 = array(
            1 => 'One',
            2 => 'Two',
            3 => 3,
            4 => 4
        );
        $array3 = array(
            1 => 'Two',
            2 => 'One',
            3 => 4,
            4 => 3
        );
        
        parent::assertTrue(ArrayUtil::compare($array1, $array2));
        parent::assertTrue(ArrayUtil::compare($array2, $array3)); // order of values doesn't matter
    }

    /**
     * Tests the compareAssoc method.
     */
    public function testCompareAssoc()
    {
        $array1 = array(
            0 => 'One',
            1 =>'Two',
            2 => 3,
            3 => 4
        );
        $array2 = array(
            1 => 'One',
            2 => 'Two',
            3 => 3,
            4 => 4
        );

        parent::assertFalse(ArrayUtil::compareAssoc($array1, $array2));
        parent::assertTrue(ArrayUtil::compareAssoc($array1, $array1));
    }
    
    /**
     * Tests the compareKey method.
     */
    public function testCompareKey()
    {
        $array1 = array(
            0 => 'One',
            1 =>'Two',
            2 => 3,
            3 => 4
        );
        $array2 = array(
            1 => 'One',
            2 => 'Two',
            3 => 3,
            0 => 4
        );

        parent::assertTrue(ArrayUtil::compareKey($array1, $array2));
        parent::assertTrue(ArrayUtil::compareKey($array1, $array1));
    }
}
 
