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

namespace XLite\View\ItemsList\Model\Order\Admin;

/**
 * Recent orders list block (for dashboard page)
 *
 * @ListChild (list="dashboard-center", weight="100", zone="admin")
 */
class RecentBlock extends \XLite\View\ItemsList\Model\Order\Admin\Search
{
    /**
     * Get URL of 'More...' link
     *
     * @return string
     */
    public function getMoreLink()
    {
        return \XLite\Core\Converter::buildURL('order_list', 'search', array('filter_id' => 'recent'));
    }

    /**
     * Get title of 'More...' link
     *
     * @return string
     */
    public function getMoreLinkTitle()
    {
        return static::t('View all open orders');
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return $this->hasResults() ? 'Recent open orders' : 'No orders have been placed yet';
    }

    /**
     * Get a list of CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/' . $this->getPageBodyDir() . '/order/recents_style.css';

        return $list;
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' recent-block';
    }

    /**
     * isEmptyListTemplateVisible
     *
     * @return boolean
     */
    protected function isEmptyListTemplateVisible()
    {
        return false;
    }

    /**
     * Define list columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $result = parent::defineColumns();

        foreach ($result as $k => $v) {
            if (isset($v[static::COLUMN_SORT])) {
                unset($result[$k][static::COLUMN_SORT]);
            }
        }

        $result['orderNumber'][static::COLUMN_TEMPLATE]
            = $this->getDir() . '/' . $this->getPageBodyDir() . '/order/cell.orderNumber_with_date.tpl';
        unset($result['date']);
        $result['paymentStatus'] = array(
            static::COLUMN_NAME     => static::t('Payment status'),
            static::COLUMN_LINK     => 'order',
            static::COLUMN_TEMPLATE => $this->getDir() . '/' . $this->getPageBodyDir() . '/order/cell.payment_status.tpl',
            static::COLUMN_ORDERBY  => 150,
        );
        $result['shippingStatus'] = array(
            static::COLUMN_NAME     => static::t('Shipping status'),
            static::COLUMN_LINK     => 'order',
            static::COLUMN_TEMPLATE => $this->getDir() . '/' . $this->getPageBodyDir() . '/order/cell.shipping_status.tpl',
            static::COLUMN_ORDERBY  => 160,
        );
        $result['total'][static::COLUMN_TEMPLATE]
            = $this->getDir() . '/' . $this->getPageBodyDir() . '/order/cell.total-clean.tpl';

        return $result;
    }

    /**
     * Hide panel
     *
     * @return null
     */
    protected function getPanelClass()
    {
        return null;
    }

    /**
     * Get search condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $cnd = \XLite\Core\Database::getRepo('XLite\Model\Order')->getRecentOrdersCondition();
        $cnd->{\XLite\Model\Repo\Order::P_ORDER_BY} = array(array('o.date', 'o.order_id'), array('DESC', 'DESC'));

        return $cnd;
    }

    /**
     * Items are non-removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return false;
    }

    /**
     * Mark list as non-selectable
     *
     * @return boolean
     */
    protected function isSelectable()
    {
        return false;
    }

    /**
     * Get pager class
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return 'XLite\View\Pager\Admin\Model\Block';
    }
}
