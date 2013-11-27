<?php

namespace Pzs\Bundle\WCFCoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The bundle class for the WCFCoreBundle.
 *
 * @author    Jim Martens <jim1@live.de>
 * @copyright 2013 Jim Martens
 * @license   http://www.gnu.org/licenses/lgpl-3.0 GNU Lesser General Public License, version 3
 */
class WCFCoreBundle extends Bundle
{
    /**
     * The option file name.
     * @var string
     */
    private $configOptionFile;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->configOptionFile = $this->container->getParameter('kernel.cache_dir') . 'option.inc.php';
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (!file_exists($this->configOptionFile)) {
            // rewrite the file
            /** @var $optionService \Pzs\Bundle\WCFCoreBundle\Service\Option\OptionServiceInterface */
            $optionService = $this->container->get('option_service');
            $optionService->rebuildFile($this->configOptionFile);
        }
        // TODO Test that this works (probably only possible in conjunction with the whole Symfony WCF edition)
        /** @noinspection PhpIncludeInspection */
        include_once($this->configOptionFile);
    }
}
