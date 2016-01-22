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

namespace XLite\Controller\Admin;

/**
 * Shipping methods management page controller
 */
class ShippingMethods extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getMethod()
            ? static::t($this->getMethod()->getProcessorObject()->getProcessorName())
            : static::t('Shipping methods');
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
        return \XLite\Core\Request::getInstance()->processor;
    }

    /**
     * Returns current carrier code
     *
     * @return string
     */
    public function getCarrierCode()
    {
        $processorId = $this->getProcessorId();

        return $processorId && $processorId !== 'offline'
            ? $processorId
            : '';
    }

    /**
     * Run controller
     *
     * @return void
     */
    protected function run()
    {
        \XLite\Core\Marketplace::getInstance()->updateShippingMethods();

        parent::run();
    }

    /**
     * doActionUpdate
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $list = $this->getMethod()
            ? new \XLite\View\ItemsList\Model\Shipping\Methods()
            : new \XLite\View\ItemsList\Model\Shipping\Carriers();

        $list->processQuick();
    }
}
