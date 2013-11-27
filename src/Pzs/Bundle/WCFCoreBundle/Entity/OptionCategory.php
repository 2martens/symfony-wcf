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
 * OptionCategory.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 *
 * @ORM\Table(name="wcf1_option_category", uniqueConstraints={@UniqueConstraint(name="categoryName", columns={"categoryName"})})
 * @ORM\Entity(repositoryClass="Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository")
 */
class OptionCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="categoryID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $categoryID;

    /**
     * @var integer
     *
     * @ORM\Column(name="packageID", type="integer")
     */
    private $packageID;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255)
     */
    private $categoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="parentCategoryName", type="string", length=255)
     */
    private $parentCategoryName;

    /**
     * @var integer
     *
     * @ORM\Column(name="showOrder", type="integer", length="10")
     */
    private $showOrder;

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
     * Get category id.
     *
     * @return integer
     */
    public function getCategoryID()
    {
        return $this->categoryID;
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
     * Set the category name.
     *
     * @param string $categoryName The name the category should have
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
     * Set parent category name.
     *
     * @param string $parentCategoryName The name of the this category's parent category
     */
    public function setParentCategoryName($parentCategoryName)
    {
        $this->parentCategoryName = $parentCategoryName;
    }

    /**
     * Get parent category name.
     *
     * @return string
     */
    public function getParentCategoryName()
    {
        return $this->parentCategoryName;
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
}
