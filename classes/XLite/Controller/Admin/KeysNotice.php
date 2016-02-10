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
 * License keys notice page controller
 */
class KeysNotice extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Return true if unallowed modules should be ignored on current page
     *
     * @return boolean
     */
    protected function isIgnoreUnallowedModules()
    {
        return true;
    }

    /**
     * Do action 'Re-check'
     *
     * @return void
     */
    protected function doActionRecheck()
    {
        // Clear cahche of some marketplace actions
        \XLite\Core\Marketplace::getInstance()->clearActionCache(
            array(
                \XLite\Core\Marketplace::ACTION_CHECK_FOR_UPDATES,
                \XLite\Core\Marketplace::ACTION_CHECK_ADDON_KEY,
                \XLite\Core\Marketplace::INACTIVE_KEYS,
            )
        );

        \XLite\Core\Marketplace::getInstance()->saveAddonsList(0);

        $returnUrl = \XLite\Core\Request::getInstance()->returnUrl ?: $this->buildURL('main');

        $this->setReturnURL($returnUrl);
    }
}
