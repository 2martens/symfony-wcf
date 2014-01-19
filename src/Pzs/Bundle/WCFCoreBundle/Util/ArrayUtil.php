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
use Pzs\Bundle\WCFCoreBundle\Exception\SystemException;

/**
 * Provides useful array functions
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013-2014 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class ArrayUtil
{
    /**
     * Applies StringUtil::trim() recursively to all elements of the given array.
     *
     * @param array   $array               The elements of this array will be trimmed
     * @param boolean $removeEmptyElements If true, empty elements will be removed
     * 
     * @return array
     */
    public static function trim($array, $removeEmptyElements = true)
    {
        if (!is_array($array)) {
            return StringUtil::trim($array);
        }
        else {
            foreach ($array as $key => $val) {
                $temp = self::trim($val, $removeEmptyElements);
                if ($removeEmptyElements && empty($temp)) {
                    unset($array[$key]);
                }
                else {
                    $array[$key] = $temp;
                }
            }
            
            return $array;
        }
    }

    /**
     * Applies intval() recursively to all elements of the given array.
     *
     * @param array $array An array with numbers or strings that contain numbers
     * 
     * @return array
     */
    public static function toIntegerArray($array)
    {
        if (!is_array($array)) {
            return intval($array);
        }
        else {
            foreach ($array as $key => $val) {
                $array[$key] = self::toIntegerArray($val);
            }
            
            return $array;
        }
    }

    /**
     * Converts recursively html special characters in the given array.
     *
     * @param array $array Should contain strings as values (direct or indirect)
     * 
     * @return array
     */
    public static function encodeHTML($array)
    {
        if (!is_array($array)) {
            return StringUtil::encodeHTML($array);
        }
        else {
            foreach ($array as $key => $val) {
                $array[$key] = self::encodeHTML($val);
            }
            
            return $array;
        }
    }

    /**
     * Applies recursively stripslashes on all elements of the given array.
     *
     * @param array $array Should contain strings as values (direct or indirect)
     * 
     * @return	array
     */
    public static function stripslashes($array)
    {
        if (!is_array($array)) {
            return stripslashes($array);
        }
        else {
            foreach ($array as $key => $val) {
                $array[$key] = self::stripslashes($val);
            }
            
            return $array;
        }
    }

    /**
     * Appends a suffix to all elements of the given array.
     *
     * @param string[] $array  An array of strings
     * @param string   $suffix The suffix
     * 
     * @return	array
     */
    public static function appendSuffix($array, $suffix)
    {
        foreach ($array as $key => $value) {
            $array[$key] = $value . $suffix;
        }

        return $array;
    }

    /**
     * Converts recursively dos to unix newlines.
     *
     * @param array $array Should contain strings as values (direct or indirect)
     * 
     * @return array
     */
    public static function unifyNewlines($array)
    {
        if (!is_array($array)) {
            return StringUtil::unifyNewlines($array);
        }
        else {
            foreach ($array as $key => $val) {
                $array[$key] = self::unifyNewlines($val);
            }
            
            return $array;
        }
    }

    /**
     * Converts an array of strings recursively to requested character encoding.
     * 
     * @param string $inCharset  The charset in which the values of the array are encoded
     * @param string $outCharset The charset to which the charset of the array should be converted
     * @param array  $array      The array with the to be converted charset
     * 
     * @return	string
     * 
     * @see	mb_convert_encoding()
     */
    public static function convertEncoding($inCharset, $outCharset, $array)
    {
        if (!is_array($array)) {
            return StringUtil::convertEncoding($inCharset, $outCharset, $array);
        }
        else {
            foreach ($array as $key => $val) {
                $array[$key] = self::convertEncoding($inCharset, $outCharset, $val);
            }
            
            return $array;
        }
    }

    /**
     * Returns true when array1 has the same values as array2 (order doesn't matter).
     *
     * @param array                                   $array1   The first array
     * @param array                                   $array2   The second array
     * @param \Pzs\Bundle\WCFCoreBundle\Util\Callback $callback The callback that should be used to compare the arrays (optional)
     * 
     * @return boolean
     */
    public static function compare(array $array1, array $array2, Callback $callback = null)
    {
        return static::compareHelper('value', $array1, $array2, $callback);
    }

    /**
     * Returns true when array1 has the same keys as array2 (order doesn't matter).
     *
     * @param array                                   $array1   The first array
     * @param array                                   $array2   The second array
     * @param \Pzs\Bundle\WCFCoreBundle\Util\Callback $callback The callback that should be used to compare the arrays (optional)
     * 
     * @return boolean
     */
    public static function compareKey(array $array1, array $array2, Callback $callback = null)
    {
        return static::compareHelper('key', $array1, $array2, $callback);
    }

    /**
     * Compares array1 with array2 and returns true when they are identical.
     *
     * @param array                                   $array1   The first array
     * @param array                                   $array2   The second array
     * @param \Pzs\Bundle\WCFCoreBundle\Util\Callback $callback The callback that should be used to compare the arrays (optional)
     * 
     * @return boolean
     */
    public static function compareAssoc(array $array1, array $array2, Callback $callback = null)
    {
        return static::compareHelper('assoc', $array1, $array2, $callback);
    }

    /**
     * Does the actual comparison of the public compare methods.
     *
     * @param string                                  $method   The method used to compare (allowed: value, key, assoc)
     * @param array                                   $array1   The first array
     * @param array                                   $array2   The second array
     * @param \Pzs\Bundle\WCFCoreBundle\Util\Callback $callback The callback used to compare the arrays (optional)
     * 
     * @return boolean
     */
    protected static function compareHelper($method, array $array1, array $array2, Callback $callback = null)
    {
        // get function name
        $function = null;
        if ($method === 'value') {
            $function = ($callback === null) ? 'array_diff' : 'array_udiff';
        }
        elseif ($method === 'key') {
            $function = ($callback === null) ? 'array_diff_key' : 'array_diff_ukey';
        }
        elseif ($method === 'assoc') {
            $function = ($callback === null) ? 'array_diff_assoc' : 'array_diff_uassoc';
        }
        else {
            return false;
        }

        // get parameters
        $params1 = array($array1, $array2);
        $params2 = array($array2, $array1);
        if ($callback !== null) {
            $params1[] = $callback;
            $params2[] = $callback;
        }

        // compare the arrays
        return ((count(call_user_func_array($function, $params1)) === 0) && (count(call_user_func_array($function, $params2)) === 0));
    }
}
 
