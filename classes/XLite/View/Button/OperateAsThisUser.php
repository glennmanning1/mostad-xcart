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
 * @ListChild (list="tabs.items", zone="admin", weight="0")
 */
class OperateAsThisUser extends \XLite\View\Button\Link
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $targets = parent::getAllowedTargets();

        $targets[] = 'profile';
        $targets[] = 'address_book';

        return $targets;
    }

    /**
     * Get default CSS class name
     *
     * @return string
     */
    protected function getDefaultStyle()
    {
        return 'action operate-as-this-user always-enabled';
    }


   /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'profile/operateAsThisUser.css';

        return $list;
    }

    /**
     * Get default label
     * todo: move translation here
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Operate as user';
    }

    /**
     * We make the full location path for the provided URL
     *
     * @return string
     */
    protected function getLocationURL()
    {
        return $this->buildURL('profile', 'operateAs', array(
            'profile_id' => $this->getProfile()->getProfileId()
        ));
    }

    /**
     * Get profile
     *
     * @return \XLite\Model\Profile
     */
    protected function getProfile()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Profile')->find(
            \XLite\Core\Request::getInstance()->profile_id
        );
    }

    /**
     * Return true if button is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getProfile()
            && $this->getProfile()->isPersistent()
            && !$this->getProfile()->getAnonymous()
            && !$this->getProfile()->isAdmin();
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[self::PARAM_BLANK]->setValue(true);
    }
}
