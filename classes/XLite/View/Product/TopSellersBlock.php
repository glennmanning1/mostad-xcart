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

namespace XLite\View\Product;

/**
 * Top sellers block widget
 */
class TopSellersBlock extends \XLite\View\Dialog
{
    const PARAM_PERIOD = 'period';

    /**
     * Add widget specific CSS file
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/style.css';

        return $list;
    }

    /**
     * Add widget specific JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/controller.js';

        return $list;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PERIOD => new \XLite\Model\WidgetParam\String('Period', $this->definePeriod()),
        );
    }

    /**
     * Return period
     *
     * @return string
     */
    protected function definePeriod()
    {
        $request = \XLite\Core\Request::getInstance();

        return $request->period ?: \XLite\View\ItemsList\Model\Product\Admin\TopSellers::P_PERIOD_LIFETIME;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'product/top_sellers';
    }

    /**
     * Get options for selector (allowed periods)
     *
     * @return array
     */
    protected function getOptions()
    {
        return \XLite\View\ItemsList\Model\Product\Admin\TopSellers::getAllowedPeriods();
    }

    /**
     * Return true if current period is a default
     *
     * @param string $period Period name
     *
     * @return boolean
     */
    protected function isDefaultPeriod($period)
    {
        return \XLite\View\ItemsList\Model\Product\Admin\TopSellers::P_PERIOD_LIFETIME === $period;
    }

    /**
     * Return true if current period is a default
     *
     * @param string $period Period name
     *
     * @return boolean
     */
    protected function isSelectedPeriod($period)
    {
        return $this->getParam(static::PARAM_PERIOD) === $period;
    }

    /**
     * Return true if there are no statistics for lifetime period
     *
     * @return boolean
     */
    protected function isEmptyStats()
    {
        return !\XLite\Core\Database::getRepo('XLite\Model\Product')
            ->hasTopSellers();
    }
    
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    protected function checkACL()
    {
        return parent::checkACL()
            && \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage catalog');
    }
}
