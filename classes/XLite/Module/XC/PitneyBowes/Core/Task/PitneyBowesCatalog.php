<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\Core\Task;

use XLite\Module\XC\PitneyBowes;

/**
 * Scheduled task that sends automatic cart reminders.
 */
class PitneyBowesCatalog extends \XLite\Core\Task\Base\Periodic
{
    const INT_1_HOUR                = 3600;
    const INT_1_DAY                 = 86400;
    const CELL_FULL_EXTRACTION      = 'pb_full_catalog_extraction';
    const CELL_DIFF_EXTRACTION      = 'pb_diff_catalog_extraction';

    /**
     * @var \XLite\Logic\Export\Generator
     */
    protected $generator;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('PB catalog actions');
    }

    /**
     * Get generator
     *
     * @return \XLite\Logic\Export\Generator
     */
    public function getGenerator()
    {
        if (!isset($this->generator)) {
            $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($this->getEventName());
            $this->generator = $state && isset($state['options']) ? new \XLite\Logic\Export\Generator($state['options']) : false;
        }

        return $this->generator;
    }

    /**
     * Get event name
     *
     * @return string
     */
    protected function getEventName()
    {
        return \XLite\Logic\Export\Generator::getEventName();
    }

    /**
     * Run step
     */
    protected function runStep()
    {
        if ($this->shouldRun()) {
            $this->checkPBNotifications();
            if ($this->shouldRunFullExtraction()) {
                $this->runSubmit();
                \XLite\Core\TmpVars::getInstance()->{static::CELL_FULL_EXTRACTION} = LC_START_TIME;
            } elseif ($this->shouldRunDiffExtraction()) {
                $this->runSubmit(true);
                \XLite\Core\TmpVars::getInstance()->{static::CELL_DIFF_EXTRACTION} = LC_START_TIME;
            }
        }

    }

    /**
     * Returns configuration
     * 
     * @return \XLite\Core\ConfigCell
     */
    protected function getConfiguration()
    {
        return \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration();
    }

    /**
     * Run catalog submission
     * 
     * @param boolean $diff Perform differential extraction (default: false, full extraction)
     * 
     * @return void
     */
    protected function runSubmit($diff = false)
    {
        \XLite\Logger::logCustom("PitneyBowes", 'Submitting catalog (diff: ' . var_export($diff, true) . ')', false);
        \XLite\Logic\Export\Generator::run(
            \XLite\Logic\Export\Generator::getPBExportOptions(
                array(
                    'differential' => $diff
                )
            )
        );
        $running = \XLite\Logic\Export\Generator::runHeadless();

        //submit to pb
        if (!$running) {
            $config = $this->getConfiguration();
            $processor = new PitneyBowes\Logic\FileExchange\Processor($config);
            $generator = $this->getGenerator();
            if ($generator) {
                $processor->submitCatalog($generator->getCatalogFiles(), $generator->getOptions()->differential);
            }
        }
    }

    /**
     * Checks if PB left some notifications on SFTP
     */
    protected function checkPBNotifications()
    {
        $config = $this->getConfiguration();
        $processor = new PitneyBowes\Logic\FileExchange\Processor($config);
        $processor->checkNotifications();
    }

    /**
     * Get period (seconds)
     *
     * @return integer
     */
    protected function getPeriod()
    {
        return static::INT_1_HOUR;
    }

    /**
     * Should run task
     * 
     * @return boolean
     */
    protected function shouldRun()
    {
        $config = $this->getConfiguration();
        return $config->sftp_catalog_directory && $config->sftp_password && $config->sftp_username;
    }

    /**
     * Check if its time to run full catalog extraction
     *
     * @return boolean
     */
    protected function shouldRunFullExtraction()
    {
        $config = $this->getConfiguration();
        $period = $config->full_catalog_extraction * static::INT_1_DAY;
        $lastRun = \XLite\Core\TmpVars::getInstance()->{static::CELL_FULL_EXTRACTION};

        return !$lastRun || ($period && LC_START_TIME > ($lastRun + $period));
    }

    /**
     * Check if its time to run diff catalog extraction
     *
     * @return boolean
     */
    protected function shouldRunDiffExtraction()
    {
        $config = $this->getConfiguration();
        $period = $config->diff_catalog_extraction * static::INT_1_HOUR;
        $lastRun = \XLite\Core\TmpVars::getInstance()->{static::CELL_DIFF_EXTRACTION};

        return !$lastRun || ($period && LC_START_TIME > ($lastRun + $period));
    }
}