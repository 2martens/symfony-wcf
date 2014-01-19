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
use Pzs\Bundle\WCFCoreBundle\Util\MathUtil;

/**
 * Tests the Math Utility.
 *
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class MathUtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the getRandomValue method.
     */
    public function testGetRandomValue()
    {
        $min = 0;
        $max = 2;
        $result = MathUtil::getRandomValue($min, $max);
        parent::assertTrue($result >= $min && $result <= $max);
    }

    /**
     * Tests the latitudeLongitudeToCartesian method. 
     */
    public function testLatitudeLongitudeToCartesian()
    {
        $longitude = 45;
        $latitude = 90;
        $lambda = $longitude * pi() / 180;
        $phi = $latitude * pi() / 180;
        
        $expected = array(
            6371 * cos($phi) * cos($lambda), // x
            6371 * cos($phi) * sin($lambda), // y
            6371 * sin($phi)                 // z
        );
        
        parent::assertEquals($expected, MathUtil::latitudeLongitudeToCartesian($latitude, $longitude));
    }
}
 
