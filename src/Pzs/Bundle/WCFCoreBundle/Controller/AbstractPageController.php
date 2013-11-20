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

namespace Pzs\Bundle\WCFCoreBundle\Controller;

use Pzs\Bundle\WCFCoreBundle\Exception\InvalidTypeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * An abstract page controller to be used for any kind of pages.
 * 
 * Usage:
 * If your controller just shows already existing data, then inherit from this class.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
abstract class AbstractPageController extends Controller implements PageControllerInterface
{

    /**
     * Template name.
     * The logical template name consisting of Bundle:Controller:templateName.
     * @var string
     */
    protected $templateName;

    /**
     * Determines if a template is to be used.
     * It is true by default.
     * @var boolean
     */
    protected $useTemplate;

    /**
     * Assigned template variables.
     * Will be filled by method call.
     * @var mixed[]
     */
    private $templateVariables;

    /**
     * Constructor.
     *
     * Overwrite if you want to change the templateName or the useTemplate setting.
     */
    public function __construct()
    {
        $this->templateName = '';
        $this->useTemplate = true;
        $this->templateVariables = array();
    }

    /**
     * Controller action.
     * Simply add a routing info to your bundle's config that
     * uses your controller's showAction method.
     * If you don't want to use a template, set the variable accordingly and
     * extend the method createResponse and return your response object.
     *
     * @throws  \Pzs\Bundle\WCFCoreBundle\Exception\InvalidTypeException    if $this->createResponse does not return an object of type Response
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public final function showAction()
    {
        $this->readParameters();
        $this->readData();
        $this->assignVariables();

        if ($this->useTemplate) {
            return $this->render(
                $this->templateName, // the view
                $this->templateVariables // the assigned template variables
            );
        } else {
            $response = $this->createResponse();
            if (!($response instanceof Response)) {
                throw new InvalidTypeException('createResponse must return an object of type Response if no template is used. Actually no template is used.');
            }

            return $response;
        }
    }

    /**
     * Creates a Response object.
     * Unless you don't want to use a template, just make basic implementation of this method
     * return null.
     *
     * @return    \Symfony\Component\HttpFoundation\Response|NULL    NULL if and only if a template is used
     */
    abstract protected function createResponse();

    // template methods following

    /**
     * Assigns the given variable with the given content.
     *
     * @param string $varName
     * @param string $varContent
     */
    protected final function assignSingle($varName, $varContent)
    {
        $varName = trim($varName);
        $this->templateVariables[$varName] = $varContent;
    }

    /**
     * Assigns multiple variables.
     *
     * @param mixed[] $variables array of form (string) $varName => (mixed) $varContent
     */
    protected final function assignMultiple(array $variables)
    {
        foreach ($variables as $varName => $varContent) {
            $varName = trim($varName);
            $this->assignSingle($varName, $varContent);
        }
    }

    /**
     * Appends the content to an already assigned variable.
     *
     * @param string $varName    has to be an assigned var
     * @param string $varContent only string variables may be appended
     *
     * @throws  \InvalidArgumentException
     */
    protected final function appendSingle($varName, $varContent)
    {
        $varName = trim($varName);
        if (!$this->isAssigned($varName)) {
            throw new \InvalidArgumentException('The varName doesn\'t belong to an assigned variable.');
        }
        if (!is_string($this->templateVariables[$varName])) {
            throw new \InvalidArgumentException('Only string values may be appended.');
        }
        $this->templateVariables[$varName] .= $varContent;
    }

    /**
     * Appends content to multiple variables.
     *
     * @param string[] $variables array of form (string) $varName => (string) $varContent
     */
    protected final function appendMultiple(array $variables)
    {
        foreach ($variables as $varName => $varContent) {
            $varName = trim($varName);
            $this->appendSingle($varName, $varContent);
        }
    }

    /**
     * Returns if a variable with the given name has been assigned.
     *
     * @param string $varName
     *
     * @return    boolean
     */
    protected final function isAssigned($varName)
    {
        $varName = trim($varName);

        return isset($this->templateVariables[$varName]);
    }

    /**
     * Returns an assigned var.
     *
     * @param string $varName has to be an assigned var
     *
     * @throws  \InvalidArgumentException
     * @return  mixed   the content belonging to the given varName
     */
    protected final function getAssignedVar($varName)
    {
        $varName = trim($varName);
        if (!$this->isAssigned($varName)) {
            throw new \InvalidArgumentException('The varName doesn\'t belong to an assigned variable.');
        }

        return $this->templateVariables[$varName];
    }
}
