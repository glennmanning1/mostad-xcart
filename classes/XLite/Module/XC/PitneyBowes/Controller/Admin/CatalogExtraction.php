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

namespace XLite\Module\XC\PitneyBowes\Controller\Admin;

use XLite\Module\XC\PitneyBowes;

/**
 * CatalogExtraction page controller
 */
class CatalogExtraction extends \XLite\Controller\Admin\AAdmin
{
    /**
     * @var \XLite\Logic\Export\Generator
     */
    protected $generator;

    /**
     * getOptionsCategory
     *
     * @return string
     */
    protected function getOptionsCategory()
    {
        return 'XC\PitneyBowes';
    }

    /**
     * Define the actions with no secure token
     *
     * @return array
     */
    public static function defineFreeFormIdActions()
    {
        return array_merge(parent::defineFreeFormIdActions(), array('export_finished'));
    }

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getProcessor()->getProcessorName();
    }

    /**
     * Get shipping processor
     *
     * @return \XLite\Model\Shipping\Processor\AProcessor
     */
    protected function getProcessor()
    {
        return new PitneyBowes\Model\Shipping\Processor\PitneyBowes();
    }

    /**
     * Returns shipping method
     *
     * @return null|\XLite\Model\Shipping\Method
     */
    public function getMethod()
    {
        /** @var \XLite\Model\Repo\Shipping\Method $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');

        return $repo->findOnlineCarrier($this->getProcessorId());
    }

    /**
     * Returns current processor id
     *
     * @return string
     */
    public function getProcessorId()
    {
        return $this->getProcessor()->getProcessorId();
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
     * Send catalog to PB SFTP
     *
     * @return void
     */
    public function doActionExport()
    {
        $isDifferential = !empty(\XLite\Core\Request::getInstance()->type) && \XLite\Core\Request::getInstance()->type === 'diff';
        \XLite\Logic\Export\Generator::run(
            \XLite\Logic\Export\Generator::getPBExportOptions(
                array('differential' => $isDifferential)
            )
        );
    }

    /**
     * Get export state
     *
     * @return boolean
     */
    public function isExportLocked()
    {
        return \XLite\Logic\Export\Generator::isLocked();
    }

    /**
     * Cancel
     *
     * @return void
     */
    public function doActionCancel()
    {
        \XLite\Logic\Export\Generator::cancel();
    }

    /**
     * Cancel
     *
     * @return void
     */
    public function doActionExportFinished()
    {
        $status = !empty(\XLite\Core\Request::getInstance()->status);
        if ($status) {
            $upload = $this->uploadToPB();
            if ($upload) {
                \XLite\Core\TopMessage::addInfo('Catalog was successfully exported to Pitney Bowes');
            } else {
                \XLite\Core\TopMessage::addError('An error has occurred during catalog upload to PB SFTP. Please try again later.');
            }
        } else {
            \XLite\Core\TopMessage::addError('An error has occurred during catalog export.');
        }
        $this->setReturnURL(
            $this->buildURL('catalog_extraction')
        );
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
     * Upload to PB SFTP Server, called from completed.tpl
     *
     * @return boolean
     */
    public function uploadToPB()
    {
        $result = false;

        $generator = $this->getGenerator();

        if ($generator) {
            $config = \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration();
            $processor = new PitneyBowes\Logic\FileExchange\Processor($config);

            $result = $processor->submitCatalog($generator->getCatalogFiles(), $generator->getOptions()->differential);
            if ($result) {
                \XLite\Core\TmpVars::getInstance()->{\XLite\Module\XC\PitneyBowes\Core\Task\PitneyBowesCatalog::CELL_DIFF_EXTRACTION} = LC_START_TIME;
                if (!$generator->getOptions()->differential) {
                    \XLite\Core\TmpVars::getInstance()->{\XLite\Module\XC\PitneyBowes\Core\Task\PitneyBowesCatalog::CELL_FULL_EXTRACTION} = LC_START_TIME;
                }
            }
        }

        return $result;
    }
}
