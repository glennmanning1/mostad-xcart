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

namespace XLite\Module\CDev\Bestsellers\View;

/**
 * New arrivals products list widget
 *
 * @ListChild (list="center", zone="customer")
 */
class BestsellersPage extends \XLite\Module\CDev\Bestsellers\View\ABestsellers
{
    /**
     * Widget target
     */
    const WIDGET_TARGET = 'bestsellers';

    /**
     * Return target to retrieve this widget from AJAX
     *
     * @return string
     */
    protected static function getWidgetTarget()
    {
        return self::WIDGET_TARGET;
    }

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = self::WIDGET_TARGET;

        return $result;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[static::PARAM_WIDGET_TYPE]->setValue(static::WIDGET_TYPE_CENTER);

        $this->widgetParams[static::PARAM_DISPLAY_MODE]->setValue(static::DISPLAY_MODE_GRID);
        $this->widgetParams[static::PARAM_GRID_COLUMNS]->setValue(3);
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return '\XLite\Module\CDev\Bestsellers\View\Pager\Customer\ControllerPager';
    }

    /**
     * Return products list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return mixed
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $this->bestsellProducts = \XLite\Core\Database::getRepo('XLite\Model\Product')
            ->findBestsellers(
                $cnd,
                0,
                $this->getRootId()
            );

        $result = true === $countOnly
            ? count($this->bestsellProducts)
            : $this->bestsellProducts;

        return $result;
    }

    /**
     * Returns empty widget head title (controller page header will be used instead)
     *
     * @return string
     */
    protected function getHead()
    {
        return '';
    }
}
