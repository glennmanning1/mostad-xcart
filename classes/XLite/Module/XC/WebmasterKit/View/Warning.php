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

namespace XLite\Module\XC\WebmasterKit\View;

/**
 * Warning
 *
 * @ListChild (list="dashboard-center", zone="admin", weight="10")
 */
class Warning extends \XLite\View\Dialog
{
    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/WebmasterKit/warning';
    }

    /**
     * Returns warning message
     *
     * @return string
     */
    protected function getMessage()
    {
        return static::t(
            'If the store is being run in production, it is strongly recommended NOT to keep the module Webmaster Kit enabled',
            array('url' => $this->getURL())
        );
    }

    /**
     * Returns webmaster kit module url
     *
     * @return string
     */
    protected function getURL()
    {
        /** @var \XLite\Model\Module $module */
        $module = \XLite\Core\Database::getRepo('XLite\Model\Module')->findOneByModuleName('XC\WebmasterKit');

        return $module->getInstalledURL();
    }

    /**
     * Change visible condition, so visible only for root admin
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Core\Auth::getInstance()->isPermissionAllowed(\XLite\Model\Role\Permission::ROOT_ACCESS);
    }
}
