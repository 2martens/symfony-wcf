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

    /**
     * Tests the unifyNewlines method.
     */
    public function testUnifyNewlines()
    {
        $testText = "\r\n" . 'hallo' . "\r";
        parent::assertEquals("\n" . 'hallo' . "\n", StringUtil::unifyNewlines($testText));
    }

    /**
     * Tests the trim method.
     */
    public function testTrim()
    {
        $testText = ' Hello Bulldog ';
        parent::assertEquals('Hello Bulldog', StringUtil::trim($testText));

        $testText = "\n".' Hello Bulldog '."\n";
        parent::assertEquals('Hello Bulldog', StringUtil::trim($testText));
    }

    /**
     * Tests the encodeHTML method.
     */
    public function testEncodeHTML()
    {
        $testText = '<html><body>Hello world</body></html>';
        parent::assertEquals('&lt;html&gt;&lt;body&gt;Hello world&lt;/body&gt;&lt;/html&gt;', 
            StringUtil::encodeHTML($testText));
    }

    /**
     * Tests the encodeJS method.
     */
    public function testEncodeJS()
    {
        $testText = 'Hello world\\bloed'."\n".'/stupid';
        parent::assertEquals('Hello world\\\\bloed\n\/stupid', StringUtil::encodeJS($testText));
    }

    /**
     * Tests the encode JSON method.
     */
    public function testEncodeJSON()
    {
        $testText = "'Hello world\\bloed'"."\n".'/stupid';
        parent::assertEquals('&#39;Hello world\\\\bloed&#39;\n\/stupid', StringUtil::encodeJSON($testText));
    }

    /**
     * Tests the decodeHTML method.
     */
    public function testDecodeHTML()
    {
        $testText = '&lt;html&gt;&lt;body&gt;Hello world&lt;/body&gt;&lt;/html&gt;';
        parent::assertEquals('<html><body>Hello world</body></html>', StringUtil::decodeHTML($testText));
    }

    /**
     * Tests the formatNumeric, formatInteger, formatNegative, addThousandsSeparator and formatDouble method.
     */
    public function testFormatNumeric()
    {
        parent::assertEquals(StringUtil::MINUS.'23', $this->stringUtil->formatNumeric(-23));
        parent::assertEquals('23', $this->stringUtil->formatNumeric(23));
        parent::assertEquals('23,000', $this->stringUtil->formatNumeric(23000));
        parent::assertEquals('42.5', $this->stringUtil->formatNumeric(42.5));
        parent::assertEquals('42', $this->stringUtil->formatNumeric(42.));
        parent::assertEquals('42.5', $this->stringUtil->formatNumeric('42.5'));
        parent::assertEquals('42', $this->stringUtil->formatNumeric('42'));
    }

    /**
     * Tests the method firstCharToUpperCase.
     */
    public function testFirstCharUpperCase()
    {
        parent::assertEquals('Char', StringUtil::firstCharToUpperCase('char'));
        parent::assertEquals('Char', StringUtil::firstCharToUpperCase('Char'));
        parent::assertEquals('CHar', StringUtil::firstCharToUpperCase('cHar'));
    }

    /**
     * Tests the method firstCharToLowerCase.
     */
    public function testFirstCharLowerCase()
    {
        parent::assertEquals('char', StringUtil::firstCharToLowerCase('char'));
        parent::assertEquals('char', StringUtil::firstCharToLowerCase('Char'));
        parent::assertEquals('cHar', StringUtil::firstCharToLowerCase('cHar'));
    }

    /**
     * Tests the method wordsToUpperCase.
     */
    public function testWordsUpperCase()
    {
        parent::assertEquals('Char Is The Best', StringUtil::wordsToUpperCase('char is the best'));
        parent::assertEquals('Char Is The Best', StringUtil::wordsToUpperCase('Char iS tHe best'));
        parent::assertEquals('Char Is The Best', StringUtil::wordsToUpperCase('Char Is The Best'));
    }

    /**
     * Tests the method replaceIgnoreCase.
     */
    public function testReplaceIgnoreCase()
    {
        parent::assertEquals('BlödmannHaßmmölüä', StringUtil::replaceIgnoreCase('Höölüäß', '', 
            'BlödmannHöölüäßHaßmmölüäHöölüäß'));
    }

    /**
     * Tests the method split.
     */
    public function testSplit()
    {
        $expected = array(
            'h',
            'e',
            'l',
            'l',
            'o',
        );
        parent::assertEquals($expected, StringUtil::split('hello', 1));

        $expected = array(
            'he',
            'll',
            'o',
        );
        parent::assertEquals($expected, StringUtil::split('hello', 2));
    }

    /**
     * Tests the method startsWith.
     */
    public function testStartsWith()
    {
        parent::assertTrue(StringUtil::startsWith('SymfonyWCF ist toll', 'Symfony'));
        parent::assertTrue(StringUtil::startsWith('SymfonyWCF ist toll', 'symfony', true));
        parent::assertFalse(StringUtil::startsWith('SymfonyWCF ist toll', 'symfony'));
        parent::assertFalse(StringUtil::startsWith('ymfonyWCF ist toll', 'Symfony'));
    }

    /**
     * Tests the method endsWith.
     */
    public function testEndsWith()
    {
        parent::assertTrue(StringUtil::endsWith('SymfonyWCF ist Toll', 'Toll'));
        parent::assertTrue(StringUtil::endsWith('SymfonyWCF ist TOll', 'toll', true));
        parent::assertFalse(StringUtil::endsWith('SymfonyWCF ist toll', 'Toll'));
        parent::assertFalse(StringUtil::endsWith('ymfonyWCF ist toll', 'TOLL'));
    }

    /**
     * Tests the method pad.
     */
    public function testPad()
    {
        $input = 'Hallöß';
        $padLength = 11;
        parent::assertEquals('Hallöß   ', StringUtil::pad($input, $padLength));
        parent::assertEquals('aHallößaa', StringUtil::pad($input, $padLength, 'a', STR_PAD_BOTH));
    }

    /**
     * Tests the method unescape.
     */
    public function testUnescape()
    {
        parent::assertEquals('hello//bus', StringUtil::unescape('hello\/\/bus', '/'));
        parent::assertEquals('hello\/\/""bus', StringUtil::unescape('hello\/\/\"\"bus'));
        parent::assertEquals('hello//""bus', StringUtil::unescape('hello\/\/\"\"bus', '/"'));
    }

    /**
     * Tests the method getCharacter.
     */
    public function testGetCharacter()
    {
        parent::assertEquals(chr(0), StringUtil::getCharacter(0));
        parent::assertEquals(chr(127), StringUtil::getCharacter(127));
        parent::assertEquals(chr(194).chr(128), StringUtil::getCharacter(128));
        parent::assertEquals(chr(223).chr(191), StringUtil::getCharacter(2047));
        parent::assertEquals(chr(224).chr(160).chr(128), StringUtil::getCharacter(2048));
    }

    /**
     * Tests the method getCharValue.
     */
    public function testGetCharValue()
    {
        parent::assertEquals(0, StringUtil::getCharValue(chr(0)));
        parent::assertEquals(127, StringUtil::getCharValue(chr(127)));
        parent::assertEquals(128, StringUtil::getCharValue(chr(194).chr(128)));
        parent::assertEquals(2047, StringUtil::getCharValue(chr(223).chr(191)));
        parent::assertEquals(2048, StringUtil::getCharValue(chr(224).chr(160).chr(128)));
        parent::assertEquals(65535, StringUtil::getCharValue(chr(239).chr(191).chr(191)));
        parent::assertEquals(65536, StringUtil::getCharValue(chr(240).chr(144).chr(128).chr(128)));
        parent::assertEquals(1049599, StringUtil::getCharValue(chr(244).chr(128).chr(143).chr(191)));
        parent::assertFalse(StringUtil::getCharValue(chr(254)));
        parent::assertFalse(StringUtil::getCharValue(chr(255)));
    }

    /**
     * Tests the method encodeAllChars.
     */
    public function testEncodeAllChars()
    {
        parent::assertEquals('&#72;&#101;&#108;&#108;&#111;&#32;&#119;&#111;&#114;&#108;&#100;&#33;', 
            StringUtil::encodeAllChars('Hello world!'));
    }

    /**
     * Tests the method isASCII.
     */
    public function testIsAscii()
    {
        parent::assertTrue(StringUtil::isASCII('Hello world!'));
        parent::assertFalse(StringUtil::isASCII('Hallöchen Wöchli'));
    }
    
    // TODO implement remaining tests
    
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
 
