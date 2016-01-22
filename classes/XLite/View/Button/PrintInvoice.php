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

namespace XLite\View\Button;

/**
 * 'Print invoice' button widget
 *
 * @ListChild (list="page.tabs.after", zone="admin", weight="100")
 */
class PrintInvoice extends \XLite\View\Button\AButton
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $targets = parent::getAllowedTargets();
        $targets[] = 'order';

        if (!\XLite::isAdminZone()) {
            $targets[] = 'checkoutSuccess';
        }

        return $targets;
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/print_invoice.js';

        return $list;
    }

    /**
     * Return CSS files list
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/print_invoice.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/print_invoice.tpl';
    }

    /**
     * Get default CSS class name
     *
     * @return string
     */
    protected function getDefaultStyle()
    {
        return 'button print-invoice';
    }

    /**
     * Get default label
     * todo: move translation here
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Print invoice';
    }

    /**
     * Returns current order
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder()
    {
        return \XLite::getController()->getOrder();
    }

    /**
     * Return URL params to use with onclick event
     *
     * @return array
     */
    protected function getURLParams()
    {
        return array(
            'url_params' => array (
                'target'       => 'order',
                'order_number' => $this->getOrder()->getOrderNumber(),
                'mode'         => 'invoice',
            ),
        );
    }
}
