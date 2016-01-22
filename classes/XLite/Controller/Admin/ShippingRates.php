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
 * Shipping rates page controller
 */
class ShippingRates extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $method = $this->getModelForm()->getModelObject();

        return $method
            ? $method->getName()
            : static::t('Shipping rates');
    }

    /**
     * Return class name for the controller main form
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\View\Model\Shipping\Offline';
    }

    /**
     * Do action update
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $this->getModelForm()->performAction('modify');

        $itemsList = new \XLite\View\ItemsList\Model\Shipping\Markups();
        $itemsList->processQuick();

        $this->setReturnURL(
            $this->buildURL(
                'shipping_rates',
                '',
                array(
                    'widget'       => 'XLite\View\Shipping\EditMethod',
                    'methodId'     => $this->getModelForm()->getModelObject()->getMethodId(),
                    'shippingZone' => \XLite\Core\Request::getInstance()->shippingZone,
                )
            )
        );

        $this->setInternalRedirect();
        \XLite\Core\Event::updateShippingMethods();
    }
}
