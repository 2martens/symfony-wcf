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

namespace Pzs\Bundle\WCFCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Option
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 *
 * @ORM\Table(name="wcf1_option", uniqueConstraints={@UniqueConstraint(name="optionName", columns={"optionName"})})
 * @ORM\Entity(repositoryClass="Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository")
 */
class Option
{
    /**
     * @var integer
     *
     * @ORM\Column(name="optionID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $optionID;

    /**
     * @var integer
     *
     * @ORM\Column(name="packageID", type="integer")
     */
    private $packageID;

    /**
     * @var string
     *
     * @ORM\Column(name="optionName", type="string", length=255)
     */
    private $optionName;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255)
     */
    private $categoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="optionType", type="string", length=255)
     */
    private $optionType;

    /**
     * @var string
     *
     * @ORM\Column(name="optionValue", type="text")
     */
    private $optionValue;

    /**
     * @var string
     *
     * @ORM\Column(name="validationPattern", type="text")
     */
    private $validationPattern;

    /**
     * @var string
     *
     * @ORM\Column(name="selectOptions", type="text")
     */
    private $selectOptions;

    /**
     * @var string
     *
     * @ORM\Column(name="enableOptions", type="text")
     */
    private $enableOptions;

    /**
     * @var integer
     *
     * @ORM\Column(name="showOrder", type="integer", length="10")
     */
    private $showOrder;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden;

    /**
     * @var string
     *
     * @ORM\Column(name="permissions", type="text")
     */
    private $permissions;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="text")
     */
    private $options;

    /**
     * @var boolean
     *
     * @ORM\Column(name="supportI18n", type="boolean")
     */
    private $supportI18n;

    /**
     * @var boolean
     *
     * @ORM\Column(name="requireI18n", type="boolean")
     */
    private $requireI18n;

    /**
     * Get option id.
     *
     * @return integer
     */
    public function getOptionID()
    {
        return $this->optionID;
    }

    /**
     * Set package id.
     *
     * @param integer $packageID The ID of the package this option belongs to
     */
    public function setPackageID($packageID)
    {
        $this->packageID = $packageID;
    }

    /**
     * Get package id.
     *
     * @return integer
     */
    public function getPackageID()
    {
        return $this->packageID;
    }

    /**
     * Set the option name.
     *
     * @param string $optionName The name the option should have
     */
    public function setOptionName($optionName)
    {
        $this->optionName = $optionName;
    }

    /**
     * Get option name.
     *
     * @return string
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * Set category name.
     *
     * @param string $categoryName The name of the category, this option should be in
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    /**
     * Get category name.
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set option type.
     *
     * @param string $optionType The type of this option
     */
    public function setOptionType($optionType)
    {
        $this->optionType = $optionType;
    }

    /**
     * Get option type.
     *
     * @return string
     */
    public function getOptionType()
    {
        return $this->optionType;
    }

    /**
     * Set option value.
     *
     * @param string $optionValue The value of this option
     */
    public function setOptionValue($optionValue)
    {
        $this->optionValue = $optionValue;
    }

    /**
     * Get option value.
     *
     * @return string
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }

    /**
     * Set validation pattern.
     *
     * @param string $validationPattern The validation pattern for this option
     */
    public function setValidationPattern($validationPattern)
    {
        $this->validationPattern = $validationPattern;
    }

    /**
     * Get validation pattern.
     *
     * @return string
     */
    public function getValidationPattern()
    {
        return $this->validationPattern;
    }

    /**
     * Set select options.
     *
     * @param string|null $selectOptions List of select options if option type is select, null otherwise
     */
    public function setSelectOptions($selectOptions)
    {
        $this->selectOptions = $selectOptions;
    }

    /**
     * Get select options.
     *
     * @return string|null If option type is not select, null is returned
     */
    public function getSelectOptions()
    {
        return $this->selectOptions;
    }

    /**
     * Set enable options.
     *
     * @param string $enableOptions List of options that are enabled by this option
     */
    public function setEnableOptions($enableOptions)
    {
        $this->enableOptions = $enableOptions;
    }

    /**
     * Get enable options.
     *
     * @return string
     */
    public function getEnableOptions()
    {
        return $this->enableOptions;
    }

    /**
     * Set show order.
     *
     * @param integer $showOrder The order at which this option is shown
     */
    public function setShowOrder($showOrder)
    {
        $this->showOrder = $showOrder;
    }

    /**
     * Get show order.
     *
     * @return integer
     */
    public function getShowOrder()
    {
        return $this->showOrder;
    }

    /**
     * Set hidden.
     *
     * @param boolean $hidden If true, this option won't be visible to the user
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns if this option is hidden.
     *
     * @return boolean
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Set permissions.
     *
     * @param string $permissions List of permissions needed to see and edit this option
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Get permissions.
     *
     * @return string
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set options.
     *
     * @param string $options The options that need to be checked to make this option visible
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Get options.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set if this option supports I18n.
     *
     * @param boolean $supportI18n If true, this option supports I18n
     */
    public function supportsI18n($supportI18n)
    {
        $this->supportI18n = $supportI18n;
    }

    /**
     * Returns if this option supports I18n.
     *
     * @return boolean
     */
    public function doesSupportI18n()
    {
        return $this->supportI18n;
    }

    /**
     * Set if this option requires I18n.
     *
     * @param boolean $requireI18n If true, this option requires I18n
     */
    public function requiresI18n($requireI18n)
    {
        $this->requireI18n = $requireI18n;
    }

    /**
     * Returns if this option requires I18n.
     *
     * @return boolean
     */
    public function doesRequireI18n()
    {
        return $this->requireI18n;
    }
}
