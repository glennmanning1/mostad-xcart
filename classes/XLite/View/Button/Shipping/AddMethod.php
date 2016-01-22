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

namespace XLite\View\Button\Shipping;

/**
 * Add shipping method popup button
 */
class AddMethod extends \XLite\View\Button\APopupButton
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'shipping/add_method/style.css';

        $onlineCarrierLink = new \XLite\View\Button\Shipping\OnlineCarrier();
        $list = array_merge($list, $onlineCarrierLink->getCSSFiles());

        $shippingTypes = new \XLite\View\Tabs\ShippingType();
        $list = array_merge($list, $shippingTypes->getCSSFiles());

        $shippingMarkups = new \XLite\View\ItemsList\Model\Shipping\Markups();
        $list = array_merge($list, $shippingMarkups->getCSSFiles());

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/shipping/add_method.js';

        $list[] = 'shipping/add_method/controller.js';

        $onlineCarrierLink = new \XLite\View\Button\Shipping\OnlineCarrier();
        $list = array_merge($list, $onlineCarrierLink->getJSFiles());

        $shippingTypes = new \XLite\View\Tabs\ShippingType();
        $list = array_merge($list, $shippingTypes->getJSFiles());

        $shippingMarkups = new \XLite\View\ItemsList\Model\Shipping\Markups();
        $list = array_merge($list, $shippingMarkups->getJSFiles());

        return $list;
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        return array(
            'target' => 'shipping_method_selection',
            'widget' => 'XLite\View\Shipping\AddMethod',
        );
    }

    /**
     * Return default button label
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Add shipping method';
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' add-shipping-method-button';
    }
}
