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

namespace XLite\Module\XC\PitneyBowes\View\StickyPanel;

/**
 * Wizard sticky panel
 */
class NotConfigured extends \XLite\View\StickyPanel\Model\AModel
{
    /**
     * Define buttons widgets
     *
     * @return array
     */
    protected function defineButtons()
    {
        $list = array();

        $list['request'] = new \XLite\Module\XC\PitneyBowes\View\Button\CredentialsForm(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => 'Request credentials',
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action always-enabled',
            )
        );

        $list['show_settings'] = new \XLite\Module\XC\PitneyBowes\View\Button\AlreadyHaveThem(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => 'Show settings',
                \XLite\View\Button\AButton::PARAM_STYLE => 'action always-enabled',
            )
        );

        $list['shipping_methods'] = new \XLite\View\Button\SimpleLink(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => static::t('Back to shipping methods'),
                \XLite\View\Button\AButton::PARAM_STYLE => 'action shipping-list-back-button',
                \XLite\View\Button\Link::PARAM_LOCATION => $this->buildURL('shipping_methods'),
            )
        );

        return $list;
    }
}
