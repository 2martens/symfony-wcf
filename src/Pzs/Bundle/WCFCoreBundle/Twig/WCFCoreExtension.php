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
 * @copyright 2011-2012 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */

namespace Pzs\Bundle\WCFCoreBundle\Twig;

use Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageServiceInterface;

/**
 * Extends Twig with the WCF template functionality.
 *
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class WCFCoreExtension extends \Twig_Extension
{
    /**
     * The language service.
     *
     * @var \Pzs\Bundle\WCFCoreBundle\Service\Language\LanguageServiceInterface
     */
    private $languageService;

    /**
     * Initializes the WCFCoreExtension.
     *
     * @param LanguageServiceInterface $languageService
     */
    public function __construct(LanguageServiceInterface $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('lang', array($this, 'langFunction')), // lang function
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getGlobals()
    {
        return array(
            '__languageService' => $this->languageService
        );
    }

    /**
     * Returns the language variable if existing
     * or the given string if it doesn't exist.
     *
     * @param string $langVar
     *
     * @return    string
     */
    public function langFunction($langVar)
    {
        $langVar = trim($langVar);
        $parsedLangVar = $this->languageService->getLanguageItem($langVar);

        return $parsedLangVar;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'wcf_extension';
    }
}
