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

namespace XLite\Module\CDev\SimpleCMS\View;

/**
 * Attribute page view
 *
 * @ListChild (list="admin.main.page.content.center", zone="admin", weight="7")
 */
class MenuFormattedPath extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(
            parent::getAllowedTargets(),
            array(
                'menus',
            )
        );
    }

    /**
     * Check if the widget is visible
     *
     * @return boolean
     */
    public function isVisible()
    {
        return parent::isVisible() && \XLite\Core\Request::getInstance()->id;
    }

    /**
     * Return the CSS files for the widget
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/SimpleCMS/menu_formatted_path/style.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/SimpleCMS/menu_formatted_path/body.tpl';
    }

    /**
     * Check if menu is current
     *
     * @return array
     */
    protected function isCurrentMenu(\XLite\Module\CDev\SimpleCMS\Model\Menu $menu)
    {
        return $this->getMenu() === $menu;
    }

    /**
     * Get menu 
     *
     * @return \XLite\Module\CDev\SimpleCMS\Model\Menu
     */
    protected function getMenu()
    {
        return \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Menu')
                ->find(intval(\XLite\Core\Request::getInstance()->id));
    }

    /**
     * Get path of current menu 
     *
     * @return array
     */
    protected function getMenuPath()
    {
        return $this->getMenu()->getPath();
    }

    /**
     * Get type of current menu 
     *
     * @return string
     */
    protected function getType()
    {
        return \XLite\Core\Request::getInstance()->page;
    }

}
