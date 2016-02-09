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
 * Bestsellers widget
 *
 * @ListChild (list="center.bottom", zone="customer", weight="400")
 * @ListChild (list="sidebar.single", zone="customer", weight="150")
 * @ListChild (list="sidebar.first", zone="customer", weight="120")
 */
class Bestsellers extends \XLite\Module\CDev\Bestsellers\View\ABestsellers
{
    /**
     * List names where the Bestsellers block is located
     */
    const SIDEBAR_LIST = 'sidebar.first';
    const SIDEBAR_SINGLE = 'sidebar.single';
    const CENTER_LIST = 'center.bottom';

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();

        $result[] = 'main';
        $result[] = 'category';

        return $result;
    }

    /**
     * Initialize widget (set attributes)
     *
     * @param array $params Widget params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        parent::setWidgetParams($params);

        $this->widgetParams[\XLite\View\Pager\APager::PARAM_SHOW_ITEMS_PER_PAGE_SELECTOR]->setValue(false);
        $this->widgetParams[\XLite\View\Pager\APager::PARAM_ITEMS_COUNT]
            ->setValue(\XLite\Core\Config::getInstance()->CDev->Bestsellers->number_of_bestsellers);
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $widgetType = \XLite\Core\Config::getInstance()->CDev->Bestsellers->bestsellers_menu
            ? static::WIDGET_TYPE_SIDEBAR
            : static::WIDGET_TYPE_CENTER;

        $this->widgetParams[static::PARAM_WIDGET_TYPE]->setValue($widgetType);

        $this->widgetParams[static::PARAM_DISPLAY_MODE]->setValue(static::DISPLAY_MODE_GRID);
        $this->widgetParams[static::PARAM_GRID_COLUMNS]->setValue(3);

        unset($this->widgetParams[static::PARAM_SHOW_DISPLAY_MODE_SELECTOR]);
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
        if (!isset($this->bestsellProducts)) {
            $limit = \XLite\Core\Config::getInstance()->CDev->Bestsellers->number_of_bestsellers;

            $this->bestsellProducts = \XLite\Core\Database::getRepo('XLite\Model\Product')
                ->findBestsellers(
                    $cnd,
                    (int)$limit,
                    $this->getRootId()
                );
        }

        $result = true === $countOnly
            ? count($this->bestsellProducts)
            : $this->bestsellProducts;

        return $result;
    }

    /**
     * Return template of Bestseller widget. It depends on widget type:
     * SIDEBAR/CENTER and so on.
     *
     * @return string
     */
    protected function getTemplate()
    {
        $template = parent::getTemplate();

        if (
            $template == $this->getDefaultTemplate()
            && static::WIDGET_TYPE_SIDEBAR == $this->getParam(static::PARAM_WIDGET_TYPE)
        ) {
            $template = 'common/sidebar_box.tpl';
        }

        return $template;
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $result = parent::isVisible();

        if (
            !\XLite\Core\CMSConnector::isCMSStarted()
            && !$this->isAJAX()
        ) {
            if (static::WIDGET_TYPE_SIDEBAR == $this->getParam(static::PARAM_WIDGET_TYPE)) {
                $result = $result && in_array($this->viewListName, array(static::SIDEBAR_LIST, static::SIDEBAR_SINGLE));
            } else {
                $result = $result && static::CENTER_LIST == $this->viewListName;
            }
        }

        return $result;
    }
}
