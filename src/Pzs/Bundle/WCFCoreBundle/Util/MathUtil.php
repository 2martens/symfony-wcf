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

namespace Pzs\Bundle\WCFCoreBundle\Util;


/**
 * Provides useful math functions.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class MathUtil
{
    /**
     * Generates a random value.
     * 
     * If both parameters are unequal to <code>null</code>, they are used.
     *
     * @param integer $min The minimum value for the random integer (optional)
     * @param integer $max The maximum value for the random integer (optional)
     * 
     * @return integer
     */
    public static function getRandomValue($min = null, $max = null)
    {
        // generate random value
        return (($min !== null && $max !== null) ? mt_rand($min, $max) : mt_rand());
    }

    /**
     * Transforms the given latitude and longitude into cartesion coordinates
     * (x, y, z).
     *
     * @param float $latitude  The latitude
     * @param float $longitude The longitude
     * 
     * @return float[]
     */
    public static function latitudeLongitudeToCartesian($latitude, $longitude)
    {
        $lambda = $longitude * pi() / 180;
        $phi = $latitude * pi() / 180;

        return array(
            6371 * cos($phi) * cos($lambda), // x
            6371 * cos($phi) * sin($lambda), // y
            6371 * sin($phi)                 // z
        );
    }
}
 
