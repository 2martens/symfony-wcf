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

namespace Pzs\Bundle\WCFCoreBundle\Util;
use Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageServiceInterface;

/**
 * Provides useful string functions.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
final class StringUtil
{
    /**
     * The html pattern
     * @var string
     */
    const HTML_PATTERN = '~</?[a-z]+[1-6]?
			(?:\s*[a-z]+\s*(=\s*(?:
			"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^\s>]
			))?)*\s*/?>~ix';
    
    /**
     * The html comment pattern
     * @var string
     */
    const HTML_COMMENT_PATTERN = '~<!--(.*?)-->~';
    
    /**
     * utf8 bytes of the HORIZONTAL ELLIPSIS (U+2026)
     * @var	string
     */
    const HELLIP = "\xE2\x80\xA6";
    
    /**
     * utf8 bytes of the MINUS SIGN (U+2212)
     * @var	string
     */
    const MINUS = "\xE2\x88\x92";

    /**
     * The language service
     * @var \Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageServiceInterface
     */
    private $languageService;

    /**
     * Constructor.
     * 
     * @param LanguageServiceInterface $languageService The language service
     */
    public function __construct(LanguageServiceInterface $languageService)
    {
        $this->languageService = $languageService;
    }
    
    /**
     * Alias to php sha1() function.
     * 
     * @param string $value The string for which a hash should be computed
     * 
     * @return string
     */
    public static function getHash($value)
    {
        return sha1($value);
    }
    
    /**
     * Creates a random hash.
     * 
     * @return string
     */
    public static function getRandomID()
    {
        return self::getHash(microtime() . uniqid(mt_rand(), true));
    }
    
    /**
     * Converts dos to unix newlines.
     * 
     * @param string $string The string in which the newlines should be unified
     * 
     * @return string
     */
    public static function unifyNewlines($string)
    {
        return preg_replace("%(\r\n)|(\r)%", "\n", $string);
    }
    
    /**
     * Swallowes whitespace from beginning and end of the string.
     * 
     * @param string $text The text that should be trimmed
     * 
     * @return string
     */
    public static function trim($text)
    {
        // Whitespace + (narrow) non breaking spaces.
        // No one can triforce now.
        $text = preg_replace('/^(\s|'.chr(226).chr(128).chr(175).'|'.chr(194).chr(160).')+/', '', $text);
        $text = preg_replace('/(\s|'.chr(226).chr(128).chr(175).'|'.chr(194).chr(160).')+$/', '', $text);
        
        return $text;
    }
    
    /**
     * Converts html special characters.
     * 
     * @param string|object $input String or object with __toString method
     * 
     * @return string
     */
    public static function encodeHTML($input)
    {
        if (is_object($input)) {
            $input = $input->__toString();
        }
        
        return @htmlspecialchars($input, ENT_COMPAT, 'UTF-8');
    }
    
    /**
     * Converts javascript special characters.
     * 
     * @param string|object $input String or object with __toString method
     * 
     * @return string
     */
    public static function encodeJS($input)
    {
        if (is_object($input)) {
            $input = $input->__toString();
        }

        // unify newlines
        $input = self::unifyNewlines($input);

        // escape backslash
        $input = str_replace("\\", "\\\\", $input);

        // escape singe quote
        $input = str_replace("'", "\'", $input);

        // escape new lines
        $input = str_replace("\n", '\n', $input);

        // escape slashes
        $input = str_replace("/", '\/', $input);

        return $input;
    }
    
    /**
     * Encodes JSON strings. This is not the same as PHP's json_encode()!
     * 
     * @param string $string The string that should be encoded for JSON
     * 
     * @return string
     */
    public static function encodeJSON($string)
    {
        $string = self::encodeJS($string);

        $string = self::encodeHTML($string);

        // single quotes must be encoded as HTML entity
        $string = str_replace("\'", "&#39;", $string);

        return $string;
    }
    
    /**
     * Decodes html entities.
     * 
     * @param string $string The string in which encoded html characters should be decoded
     * 
     * @return string
     */
    public static function decodeHTML($string)
    {
        $string = str_ireplace('&nbsp;', ' ', $string); // convert non-breaking spaces to ascii 32; not ascii 160
        
        return @html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }
    
    /**
     * Formats a numeric.
     * 
     * @param number $numeric The number that should formatted
     * 
     * @return string
     */
    public function formatNumeric($numeric)
    {
        if (is_int($numeric)) {
            return $this->formatInteger($numeric);
        }
        elseif (is_float($numeric)) {
            return $this->formatDouble($numeric);
        }
        else {
            // if $numeric contains a string, this if statement is executed
            // if the string contains a float value, it is formatted as double
            if (floatval($numeric) - (float) intval($numeric)) {
                return $this->formatDouble($numeric);
            }
            // otherwise it is formatted as integer
            else {
                return $this->formatInteger(intval($numeric));
            }
        }
    }
    
    /**
     * Formats an integer.
     * 
     * @param integer $integer The integer that should be formatted
     * 
     * @return	string
     */
    public function formatInteger($integer)
    {
        $integer = $this->addThousandsSeparator($integer);

        // format minus
        $integer = self::formatNegative($integer);

        return $integer;
    }
    
    /**
     * Formats a double.
     * 
     * @param double  $double      The double that should be formatted
     * @param integer $maxDecimals The maximum amount of decimals that should be shown
     * 
     * @return	string
     */
    public function formatDouble($double, $maxDecimals = 0)
    {
        // consider as integer, if no decimal places found
        if (!$maxDecimals && preg_match('~^(-?\d+)(?:\.(?:0*|00[0-4]\d*))?$~', $double, $match)) {
            return $this->formatInteger($match[1]);
        }

        // round
        $double = round($double, ($maxDecimals > 2 ? $maxDecimals : 2));

        // remove last 0
        if ($maxDecimals < 2 && substr($double, -1) == '0') $double = substr($double, 0, -1);

        // replace decimal point
        $double = str_replace('.', $this->languageService->getLanguageItem('wcf.global.decimalPoint'), $double);

        // add thousands separator
        $double = self::addThousandsSeparator($double);

        // format minus
        $double = self::formatNegative($double);

        return $double;
    }
    
    /**
     * Adds thousands separators to a given number.
     * 
     * @param string $number Number to which the thousands separator should be added
     * 
     * @return	string
     */
    public function addThousandsSeparator($number)
    {
        if (intval($number) >= 1000 || intval($number) <= -1000) {
            $number = preg_replace('~(?<=\d)(?=(\d{3})+(?!\d))~', 
                $this->languageService->getLanguageItem('wcf.global.thousandsSeparator'), 
                $number
            );
        }

        return $number;
    }
    
    /**
     * Replaces the MINUS-HYPHEN with the MINUS SIGN.
     * 
     * @param string $number Number that should be formatted as a negative number
     *                       
     * @return string
     */
    public static function formatNegative($number)
    {
        return str_replace('-', self::MINUS, $number);
    }
    
    /**
     * Alias to php ucfirst() function with multibyte support.
     * 
     * @param string $string The string in which the first char should be made uppercase.
     *                       
     * @return string
     */
    public static function firstCharToUpperCase($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
    }
    
    /**
     * Alias to php lcfirst() function with multibyte support.
     * 
     * @param string $string The string in which the first char should be made lowercase
     * 
     * @return string
     */
    public static function firstCharToLowerCase($string)
    {
        return mb_strtolower(mb_substr($string, 0, 1)).mb_substr($string, 1);
    }
    
    /**
     * Alias to php mb_convert_case() function.
     * 
     * @param string $string The string for which the first chars of each word should be made uppercase
     * 
     * @return string
     */
    public static function wordsToUpperCase($string)
    {
        return mb_convert_case($string, MB_CASE_TITLE);
    }
    
    /**
     * Alias to php str_ireplace() function with UTF-8 support.
     * 
     * This function is considered to be slow, if $search contains
     * only ASCII characters, please use str_ireplace() instead.
     * 
     * @param string  $search  The needle
     * @param string  $replace The replacement for the needle
     * @param string  $subject The haystack
     * @param integer &$count  Outbound variable that will get assigned the amount of times $search occurs in $subject 
     * 
     * @return string
     */
    public static function replaceIgnoreCase($search, $replace, $subject, &$count = 0)
    {
        $startPos = mb_strpos(mb_strtolower($subject), mb_strtolower($search));
        if ($startPos === false) {
            return $subject;
        }
        else {
            $endPos = $startPos + mb_strlen($search);
            $count++;
            
            return mb_substr($subject, 0, $startPos) . $replace . self::replaceIgnoreCase($search, $replace, mb_substr($subject, $endPos), $count);
        }
    }
    
    /**
     * Alias to php str_split() function with multibyte support.
     * 
     * @param string  $string The string that should be split
     * @param integer $length The length of each of the substrings (optional, by default 1)
     * 
     * @return string[]
     */
    public static function split($string, $length = 1)
    {
        $result = array();
        for ($i = 0, $max = mb_strlen($string); $i < $max; $i += $length) {
            $result[] = mb_substr($string, $i, $length);
        }
        
        return $result;
    }
    
    /**
     * Checks wether $haystack starts with $needle, or not.
     * 
     * @param string  $haystack The string to be checked for starting with $needle
     * @param string  $needle   The string to be found at the start of $haystack
     * @param boolean $ci       Case insensitive or not. Default = false.
     * 
     * @return boolean True, if $haystack starts with $needle, false otherwise.
     */
    public static function startsWith($haystack, $needle, $ci = false)
    {
        if ($ci) {
            $haystack = mb_strtolower($haystack);
            $needle = mb_strtolower($needle);
        }
        // using mb_substr and === is MUCH faster for long strings then using indexOf.
        return mb_substr($haystack, 0, mb_strlen($needle)) === $needle;
    }
    
    /**
     * Returns true if $haystack ends with $needle or if the length of $needle is 0.
     * 
     * @param string  $haystack The string to be checked for ending with $needle
     * @param string  $needle   The string to be found at the end of $haystack
     * @param boolean $ci       Case insensitive or not. Default = false.
     * 
     * @return	boolean
     */
    public static function endsWith($haystack, $needle, $ci = false)
    {
        if ($ci) {
            $haystack = mb_strtolower($haystack);
            $needle = mb_strtolower($needle);
        }
        $length = mb_strlen($needle);
        if ($length === 0) {
            return true;
        }
        
        return (mb_substr($haystack, $length * -1) === $needle);
    }
    
    /**
     * Alias to php str_pad function with multibyte support.
     * 
     * @param string  $input     The input string
     * @param integer $padLength The pad length
     * @param string  $padString The pad string
     * @param integer $padType   by default STR_PAD_RIGHT
     * 
     * @return string
     */
    public static function pad($input, $padLength, $padString=' ', $padType=STR_PAD_RIGHT)
    {
        $additionalPadding = strlen($input) - mb_strlen($input);
        
        return str_pad($input, $padLength + $additionalPadding, $padString, $padType);
    }
    
    /**
     * Unescapes escaped characters in a string.
     * 
     * @param string $string The string in which $chars should be unescaped
     * @param string $chars  The characters that should be unescaped
     * 
     * @return	string
     */
    public static function unescape($string, $chars = '"')
    {
        for ($i = 0, $j = strlen($chars); $i < $j; $i++) {
            $string = str_replace('\\'.$chars[$i], $chars[$i], $string);
        }

        return $string;
    }
    
    /**
     * Takes a numeric HTML entity value and returns the appropriate UTF-8 bytes.
     * 
     * @param integer $dec html entity value
     * 
     * @return string utf-8 bytes
     */
    public static function getCharacter($dec)
    {
        if ($dec < 128) {
            $utf = chr($dec);
        }
        elseif ($dec < 2048) {
            $utf = chr(192 + (($dec - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        }
        else {
            $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
            $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        }
        
        return $utf;
    }
    
    /**
     * Converts UTF-8 to Unicode
     * 
     * @param string $c The character from which the character value should be computed
     * 
     * @see http://www1.tip.nl/~t876506/utf8tbl.html
     * 
     * @return integer|boolean false on error
     */
    public static function getCharValue($c)
    {
        $ud = 0;
        if (ord($c{0}) >= 0 && ord($c{0}) <= 127) {
            $ud = ord($c{0});
        }
        if (ord($c{0}) >= 192 && ord($c{0}) <= 223) {
            $ud = (ord($c{0}) - 192) * 64 + (ord($c{1}) - 128);
        }
        if (ord($c{0}) >= 224 && ord($c{0}) <= 239) {
            $ud = (ord($c{0}) - 224) * 4096 + (ord($c{1}) - 128) * 64 + (ord($c{2}) - 128);
        }
        if (ord($c{0}) >= 240 && ord($c{0}) <= 247) {
            $ud = (ord($c{0}) - 240) * 262144 + (ord($c{1}) - 128) * 4096 + (ord($c{2}) - 128) * 64 + (ord($c{3}) - 128);
        }
        if (ord($c{0}) >= 248 && ord($c{0}) <= 251) {
            $ud = (ord($c{0}) - 248) * 16777216 + (ord($c{1}) - 128) * 262144 + (ord($c{2}) - 128) * 4096 
                + (ord($c{3}) - 128) * 64 + (ord($c{4}) - 128);
        }
        if (ord($c{0}) >= 252 && ord($c{0}) <= 253) {
            $ud = (ord($c{0}) - 252) * 1073741824 + (ord($c{1}) - 128) * 16777216 + (ord($c{2}) - 128) * 262144 
                + (ord($c{3}) - 128) * 4096 + (ord($c{4}) - 128) * 64 + (ord($c{5}) - 128);
        }
        if (ord($c{0}) >= 254 && ord($c{0}) <= 255) {
            $ud = false; // error
        }
        
        return $ud;
    }
    
    /**
     * Returns html entities of all characters in the given string.
     *
     * @param string $string The string that should be encoded
     * 
     * @return	string
     */
    public static function encodeAllChars($string)
    {
        $result = '';
        for ($i = 0, $j = mb_strlen($string); $i < $j; $i++) {
            $char = mb_substr($string, $i, 1);
            $result .= '&#'.self::getCharValue($char).';';
        }

        return $result;
    }
    
    /**
     * Returns true if the given string contains only ASCII characters.
     * 
     * @param string $string The string that should be checked
     * 
     * @return boolean
     */
    public static function isASCII($string)
    {
        return (boolean) preg_match('/^[\x00-\x7F]*$/', $string);
    }
    
    /**
     * Returns true if the given string is utf-8 encoded.
     *
     * @param string $string The string that should be checked
     * 
     * @see http://www.w3.org/International/questions/qa-forms-utf-8
     * 
     * @return	boolean
     */
    public static function isUTF8($string)
    {
        /*return preg_match('/^(
                [\x09\x0A\x0D\x20-\x7E]*		# ASCII
            |	[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
            |	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
            |	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
            |	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
            |	\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
            |	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
            |	\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
            )*$/x', $string);
        */
        return preg_match('/(
				[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
			|	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
			|	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
			|	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
			|	\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
			|	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
			|	\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
			)/x', $string);
    }
    
    /**
     * Escapes the closing cdata tag.
     * 
     * @param string $string The string in which CDATA blocks should be encoded
     * 
     * @return string
     */
    public static function escapeCDATA($string)
    {
        return str_replace(']]>', ']]]]><![CDATA[>', $string);
    }
    
    /**
     * Converts a string to requested character encoding.
     * 
     * @param string $inCharset  The input charset
     * @param string $outCharset The output charset
     * @param string $string     The input
     *
     * @see		mb_convert_encoding()
     *
     * @return string converted string
     */
    public static function convertEncoding($inCharset, $outCharset, $string)
    {
        if ($inCharset == 'ISO-8859-1' && $outCharset == 'UTF-8') {
            return utf8_encode($string);
        }
        if ($inCharset == 'UTF-8' && $outCharset == 'ISO-8859-1') {
            return utf8_decode($string);
        }
        
        return mb_convert_encoding($string, $outCharset, $inCharset);
    }
    
    /**
     * Strips HTML tags from a string.
     * 
     * @param string $string The string from which html tags should be stripped
     * 
     * @return string
     */
    public static function stripHTML($string)
    {
        return preg_replace(self::HTML_PATTERN, '', preg_replace(self::HTML_COMMENT_PATTERN, '', $string));
    }
    
    /**
     * Returns false if the given word is forbidden by given word filter.
     * 
     * @param string $word   The word that should be checked
     * @param string $filter The filter the word should be checked against
     * 
     * @return boolean
     */
    public static function executeWordFilter($word, $filter)
    {
        $word = mb_strtolower($word);
        
        if ($filter != '') {
            $forbiddenNames = explode("\n", mb_strtolower(self::unifyNewlines($filter)));
            foreach ($forbiddenNames as $forbiddenName) {
                if (mb_strpos($forbiddenName, '*') !== false) {
                    $forbiddenName = str_replace('\*', '.*', preg_quote($forbiddenName, '/'));
                    if (preg_match('/^'.$forbiddenName.'$/s', $word)) {
                        return false;
                    }
                }
                else {
                    if ($word == $forbiddenName) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    /**
     * Truncates the given string to a certain number of characters.
     * 
     * @param string  $string     string which shall be truncated
     * @param integer $length     string length after truncating
     * @param string  $etc        string to append when $string is truncated
     * @param boolean $breakWords should words be broken in the middle
     * 
     * @return string truncated string
     */
    public static function truncate($string, $length = 80, $etc = self::HELLIP, $breakWords = false)
    {
        if ($length == 0) {
            return '';
        }

        if (mb_strlen($string) > $length) {
            $length -= mb_strlen($etc);

            if (!$breakWords) {
                $string = preg_replace('/\\s+?(\\S+)?$/', '', mb_substr($string, 0, $length + 1));
            }

            return mb_substr($string, 0, $length).$etc;
        }
        else {
            return $string;
        }
    }
    
    /**
     * Truncates a string containing HTML code and keeps the HTML syntax intact.
     * 
     * @param string  $string     string which shall be truncated
     * @param integer $length     string length after truncating
     * @param string  $etc        ending string which will be appended after truncating
     * @param boolean $breakWords if false words will not be split and the return string might be shorter than $length
     * 
     * @return string truncated string
     */
    public static function truncateHTML($string, $length = 500, $etc = self::HELLIP, $breakWords = false)
    {
        if (mb_strlen(self::stripHTML($string)) <= $length) {
            return $string;
        }
        $openTags = array();
        $truncatedString = '';

        // initalize length counter with the ending length
        $totalLength = mb_strlen($etc);

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $string, $tags, PREG_SET_ORDER);

        foreach ($tags as $tag) {
            // filter standalone html tags
            if (!preg_match('/area|base|basefont|br|col|frame|hr|img|input|isindex|link|meta|param/s', $tag[2])) {
                // look for opening tags
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                }
                /**
                 * look for closing tags and check if this tag has a corresponding opening tag
                 * and omit the opening tag if it has been closed already
                 */
                elseif (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $position = array_search($closeTag[1], $openTags);
                    if ($position !== false) {
                        array_splice($openTags, $position, 1);
                    }
                }
            }
            // append tag
            $truncatedString .= $tag[1];

            // get length of the content without entities. If the content is too long, keep entities intact
            $decodedContent = self::decodeHTML($tag[3]);
            $contentLength = mb_strlen($decodedContent);
            if ($contentLength + $totalLength > $length) {
                if (!$breakWords) {
                    if (preg_match('/^(.{1,'.($length - $totalLength).'}) /s', $decodedContent, $match)) {
                        $truncatedString .= self::encodeHTML($match[1]);
                    }

                    break;
                }

                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', 
                    $tag[3], 
                    $entities, 
                    PREG_OFFSET_CAPTURE
                )) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        }
                        else {
                            break;
                        }
                    }
                }
                $truncatedString .= mb_substr($tag[3], 0, $left + $entitiesLength);
                break;
            }
            else {
                $truncatedString .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }

        // close all open tags
        foreach ($openTags as $tag) {
            $truncatedString .= '</'.$tag.'>';
        }

        // add etc
        $truncatedString .= $etc;

        return $truncatedString;
    }
    
    /**
     * Generates an anchor tag from given URL.
     * 
     * @param string  $url         The URL
     * @param string  $title       The title
     * @param boolean $encodeTitle If true, the title is encoded
     * 
     * @return string anchor tag
     */
    public static function getAnchorTag($url, $title = '', $encodeTitle = true)
    {
        $external = true;
        // TODO resolve dependency to application handler
        if (ApplicationHandler::getInstance()->isInternalURL($url)) {
            $external = false;
        }
        
        // cut visible url
        if (empty($title)) {
            // use URL and remove protocol and www subdomain
            $title = preg_replace('~^(?:https?|ftps?)://(?:www\.)?~i', '', $url);
            
            if (mb_strlen($title) > 60) {
                $title = mb_substr($title, 0, 30) . self::HELLIP . mb_substr($title, -25);
            }
            
            if (!$encodeTitle) $title = self::encodeHTML($title);
        }
        // TODO resolve Options
        return '<a href="'.self::encodeHTML($url).'"'
            .($external 
                ? (' class="externalURL"'
                    .(EXTERNAL_LINK_REL_NOFOLLOW 
                        ? ' rel="nofollow"' 
                        : ''
                    )
                    .(EXTERNAL_LINK_TARGET_BLANK 
                        ? ' target="_blank"' 
                        : ''
                    )
                ) 
                : ''
            )
            .'>'
            .($encodeTitle 
                ? self::encodeHTML($title) 
                : $title
            )
            .'</a>';
    }
    
    /**
     * Splits given string into smaller chunks.
     * 
     * @param string  $string The string that should be splitted
     * @param integer $length The length of each chunk
     * @param string  $break  The separator between the chunks
     * 
     * @return	string
     */
    public static function splitIntoChunks($string, $length = 75, $break = "\r\n")
    {
        return mb_ereg_replace('.{'.$length.'}', "\\0".$break, $string);
    }
    
    /**
     * Simple multi-byte safe wordwrap() function.
     * 
     * @param string  $string The string
     * @param integer $width  The width
     * @param string  $break  The break to get substrings from the string
     * 
     * @return string
     */
    public static function wordwrap($string, $width = 50, $break = ' ')
    {
        $result = '';
        $substrings = explode($break, $string);
        
        foreach ($substrings as $substring) {
            $length = mb_strlen($substring);
            if ($length > $width) {
                $j = ceil($length / $width);
                
                for ($i = 0; $i < $j; $i++) {
                    if (!empty($result)) {
                        $result .= $break;
                    }
                    if ($width * ($i + 1) > $length) {
                        $result .= mb_substr($substring, $width * $i);
                    }
                    else {
                        $result .= mb_substr($substring, $width * $i, $width);
                    }
                }
            }
            else {
                if (!empty($result)) {
                    $result .= $break;
                }
                $result .= $substring;
            }
        }
        
        return $result;
    }

}
 
