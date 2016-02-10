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

namespace XLite\Module\Amazon\PayWithAmazon\View\Tabs;

/**
 * Tabs related to payment settings
 *
 */
class PaymentSettings extends \XLite\View\Tabs\PaymentSettings implements \XLite\Base\IDecorator
{
    /**
     * Returns a list of targets for which the tabs are visible
     *
     * @return array
     */
    protected function getTabTargets()
    {
        return array_merge(
            parent::getTabTargets(),
            array('pay_with_amazon')
        );
    }

    /**
     * Sorting the tabs according their weight
     *
     * @return array
     */
    protected function prepareTabs()
    {
        $this->tabs = array_merge(
            $this->tabs,
            array(
                'pay_with_amazon' => array(
                    'title'     => 'Pay with Amazon',
                    'widget'    => '\XLite\View\Model\Settings',
                )
            )
        );

        return parent::prepareTabs();
    }
}
