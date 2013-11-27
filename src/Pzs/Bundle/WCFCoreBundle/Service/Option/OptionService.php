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

namespace Pzs\Bundle\WCFCoreBundle\Service\Option;

use Pzs\Bundle\WCFCoreBundle\Cache\Builder\OptionCacheBuilder;
use Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository;
use Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository;
use Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Manages the options.
 * 
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class OptionService implements OptionServiceInterface
{
    /**
     * The cache service
     * @var \Pzs\Bundle\WCFCoreBundle\Service\Cache\CacheServiceInterface
     */
    private $cacheService;

    /**
     * The option repository
     * @var \Pzs\Bundle\WCFCoreBundle\Repository\OptionRepository
     */
    private $optionRepository;

    /**
     * The option category repository
     * @var \Pzs\Bundle\WCFCoreBundle\Repository\OptionCategoryRepository
     */
    private $optionCategoryRepository;

    /**
     * The file system
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fileSystem;

    /**
     * Constructor.
     * 
     * @param OptionRepository         $optionRepository         The option repository
     * @param OptionCategoryRepository $optionCategoryRepository The option category repository
     * @param CacheServiceInterface    $cacheService             The cache service
     * @param Filesystem               $fileSystem               The file system
     */
    public function __construct(OptionRepository $optionRepository,
                                OptionCategoryRepository $optionCategoryRepository,
                                CacheServiceInterface $cacheService,
                                Filesystem $fileSystem)
    {
        $this->cacheService = $cacheService;
        $this->optionRepository = $optionRepository;
        $this->optionCategoryRepository = $optionCategoryRepository;
        $this->fileSystem = $fileSystem;
    }

    /**
     * {@inheritdoc}
     */
    public function rebuildFile($filename)
    {
        $cacheBuilder = new OptionCacheBuilder($this->optionRepository, $this->optionCategoryRepository);
        /** @var \Pzs\Bundle\WCFCoreBundle\Entity\Option[] $options */
        $options = $this->cacheService->get($cacheBuilder, 'optionsByName');
        
        // build the string that will be written to file
        $buffer = "<?php\n/**\n* generated at %TIME%\n*/\n";
        foreach ($options as $optionName => $option) {
            $buffer .= "if (!defined('".strtoupper($optionName)."')) define('".strtoupper($optionName)."', "
                    .(($option->getOptionType() == 'boolean' || $option->getOptionType() == 'integer') 
                    ? intval($option->getOptionValue()) 
                    : "'".addcslashes($option->getOptionValue(), "'\\")."'")
                .");\n";
        }
        $buffer .= "\n";
        
        // the returned output may not contain the actual date as comparing for the correct result won't be possible 
        $bufferWritten = str_replace('%TIME%', gmdate('r'), $buffer);
        // writes file
        $this->fileSystem->dumpFile($filename, $bufferWritten);
        
        return $buffer;
    }
}
