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

namespace XLite\Module\Amazon\PayWithAmazon\View;

/**
 * Amazon checkout widget
 *
 * @ListChild (list="center", zone="customer")
 */
class AmazonCheckout extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('amazon_checkout'));
    }

   /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/Amazon/PayWithAmazon/checkout.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'checkout/steps/review/parts/items.js';

        return $list;
    }

    // compat with mailchimp module
    public function getProfile()
    {
        return \XLite::getController()->getCart()->getProfile();
    }

    /**
     * Get current refid
     *
     * @return string
     */
    public function getAmazonOrderRefId()
    {
        return \XLite\Core\Request::getInstance()->amz_pa_ref;
    }

    /**
     * Check if order has only non-shippable products
     *
     * @return boolean
     */
    public function isOrderShippable()
    {
        $modifier = \XLite::getController()->getCart()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        return $modifier && $modifier->canApply();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        if (!\XLite::isAdminZone() && method_exists('\XLite\Core\Request', 'isMobileDevice') && \XLite\Core\Request::isMobileDevice()) {
            return 'modules/Amazon/PayWithAmazon/checkout_mobile.tpl';
        } else {
            return 'modules/Amazon/PayWithAmazon/checkout.tpl';
        }
    }

}
