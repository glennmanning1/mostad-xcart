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

namespace XLite\Module\CDev\SimpleCMS\View\Menu\Customer;

/**
 * Primary menu
 */
class PrimaryMenu extends \XLite\View\Menu\Customer\Top implements \XLite\Base\IDecorator
{
    /**
     * Define menu items
     *
     * @return array
     */
    protected function defineItems()
    {
        $menu = array();
        $cnd = new \XLite\Core\CommonCell;
        $cnd->type = \XLite\Module\CDev\SimpleCMS\Model\Menu::MENU_TYPE_PRIMARY;
        $cnd->enabled = true;
        $cnd->visibleFor = array(
            'AL',
            (\XLite\Core\Auth::getInstance()->isLogged() ? 'L' : 'A'),
        );

        $menus = \XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Menu')->getMenusPlainList($cnd);
        foreach ($menus as $menuItem) {
            $menu[] = array(
                'id'          => $menuItem->getId(),
                'label'       => $menuItem->getName(),
                'depth'       => $menuItem->getDepth(),
                'controller'  => $menuItem->getLinkController(),
                'url'         => $menuItem->getUrl(),
                'hasSubmenus' => $menuItem->getSubmenusCount() > 0,
            );
        }

        if (!$menu) {
            foreach (\XLite\Core\Database::getRepo('XLite\Module\CDev\SimpleCMS\Model\Menu')->search($cnd) as $v) {
                $menu[] = $this->defineItem($v);
            }
            $menu = \XLite\Core\Config::getInstance()->CDev->SimpleCMS->show_default_menu
                ? array_merge(parent::defineItems(), $menu)
                : ($menu ?: parent::defineItems());
        }

        return $menu;
    }

    /**
     * Define Menu item
     *
     * @param \XLite\Module\CDev\SimpleCMS\Model\Menu $menuItem Menu item
     *
     * @return array
     */
    protected function defineItem(\XLite\Module\CDev\SimpleCMS\Model\Menu $menuItem)
    {
        return array(
            'url'           => $menuItem->getURL(),
            'label'         => $menuItem->getName(),
            'controller'    => $menuItem->getLinkController(),
        );
    }

    /**
     * Previous menu depth
     *
     * @var integer
     */
    protected $prevMenuDepth = 0;

    /**
     * Is first element
     *
     * @var integer
     */
    protected $isFirst = true;

    /**
     * Return the CSS files for the menu
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/SimpleCMS/css/primary_menu.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/SimpleCMS/primary_menu.tpl';
    }

    /**
     * Return next menu level or not
     *
     * @param integer $menuDepth Level depth
     *
     * @return boolean
     */
    protected function isLevelUp($menuDepth)
    {
        $result = false;
        if ($menuDepth > $this->prevMenuDepth) {
            $result = true; 
            $this->prevMenuDepth = $menuDepth;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Return previous menu level or not
     *
     * @param integer $menuDepth Level depth
     *
     * @return boolean
     */
    protected function isLevelBelow($menuDepth)
    {
        $result = false;
        if ($menuDepth < $this->prevMenuDepth) {
            $result = true; 
            $this->prevMenuDepth = $menuDepth;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Return is level changed
     *
     * @return boolean
     */
    protected function closeMenuList($menuDepth = 0)
    {
        $result = '';
        for ($i = $menuDepth;$i<$this->prevMenuDepth;$i++) {
            $result .= '</ul></li>';
        }
        $this->prevMenuDepth = $menuDepth;

        return $result;
    }

    /**
     * Return is first element
     *
     * @return boolean
     */
    protected function isFirstElement()
    {
        $result = $this->isFirst;
        $this->isFirst = false;

        return $result;
    }

    /**
     * Display item class as tag attribute
     *
     * @param integer $index Item index
     * @param mixed   $item  Item element
     *
     * @return string
     */
    protected function displayItemClass($index, $item)
    {
        $class = parent::displayItemClass($index, $item);

        return $item['hasSubmenus'] && $item['depth'] > 0
            ?  preg_replace('/"$/', ' has-sub"', $class)
            :  $class;
    }
}
