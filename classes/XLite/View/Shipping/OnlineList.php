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

namespace XLite\View\Shipping;

/**
 * Online shipping carriers list
 */
class OnlineList extends \XLite\View\AView
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'shipping/online_list/body.tpl';
    }

    /**
     * Returns online shipping methods (carriers)
     *
     * @return \XLite\Model\Shipping\Method[]
     */
    protected function getMethods()
    {
        /** @var \XLite\Model\Repo\Shipping\Method $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');

        return $repo->findOnlineCarriers();
    }

    /**
     * Returns shipping carrier settings url
     *
     * @param \XLite\Model\Shipping\Method $method Shipping method
     *
     * @return string
     */
    protected function getSettingsURL(\XLite\Model\Shipping\Method $method)
    {
        $url = null;

        $module = $method->getProcessorModule();

        if ($module) {

            if ($module->isInstalled() && $module->getEnabled()) {
                $url = $method->getProcessorObject()
                    ? $method->getProcessorObject()->getSettingsURL()
                    : '';

            } elseif ($module->isInstalled()) {
                $url = $module->getInstalledURL();

            } else {
                $url = $module->getMarketplaceURL();
            }
        }

        return $url;
    }
}
