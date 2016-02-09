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

namespace XLite\View\SearchPanel\Order\Admin;

/**
 * Main admin orders list search panel
 */
class Main extends \XLite\View\SearchPanel\Order\Admin\AAdmin
{
    /**
     * Via this method the widget registers the CSS files which it uses.
     * During the viewers initialization the CSS files are collecting into the static storage.
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'search_panel/order/style.css';

        return $list;
    }

    /**
     * Get form class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\View\Form\Order\Search';
    }

    /**
     * Define the items list CSS class with which the search panel must be linked
     *
     * @return string
     */
    protected function getLinkedItemsList()
    {
        return parent::getLinkedItemsList() . '.widget.items-list.orders';
    }

    /**
     * Define conditions
     *
     * @return array
     */
    protected function defineConditions()
    {
        return parent::defineConditions() + array(
            'substring' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY         => true,
                \XLite\View\FormField\Input\Text::PARAM_PLACEHOLDER => static::t('Enter OrderID or email'),
            ),
            'paymentStatus' => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Select\CheckboxList\OrderStatus\Payment',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY          => true,
            ),
            'shippingStatus' => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Select\CheckboxList\OrderStatus\Shipping',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY          => true,
            ),
            'dateRange' => array(
                static::CONDITION_CLASS => '\XLite\View\FormField\Input\Text\DateRange',
                \XLite\View\FormField\AFormField::PARAM_FIELD_ONLY  => true,
            ),
        );
    }

    /**
     * Define hidden conditions
     *
     * @return array
     */
    protected function defineHiddenConditions()
    {
        return parent::defineHiddenConditions() + array(
            'customerName' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Text\Profile',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Customer'),
                \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('Customer name'),
                \XLite\View\FormField\Input\Text\Profile::PARAM_PROFILE_ID => $this->getCondition('profileId'),
                \XLite\View\FormField\Input\Text\Profile::PARAM_AUTOCOMPLETE => true,
            ),
            'accessLevel' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Select\Order\CustomerAccessLevel',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Customer access level'),
            ),
            'zipcode' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Customer zip/postal code'),
            ),
            'transactionID' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Payment transaction ID'),
            ),
            'sku' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Text',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('SKU'),
                \XLite\View\FormField\Input\AInput::PARAM_PLACEHOLDER => static::t('SKU or SKU1, SKU2'),
            ),
            'recent' => array(
                static::CONDITION_CLASS => 'XLite\View\FormField\Input\Checkbox',
                \XLite\View\FormField\AFormField::PARAM_LABEL => static::t('Recent orders only'),
                \XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => $this->getCondition('recent'),
                \XLite\View\FormField\Input\Checkbox::PARAM_VALUE => '1',
            ),
        );
    }

    /**
     * Return true if search panel should use filters
     *
     * @return boolean
     */
    protected function isUseFilter()
    {
        return true;
    }

    /**
     * Get name of the 'Reset filter' option
     *
     * @return string
     */
    protected function getClearFilterName()
    {
        return static::t('All orders');
    }

    /**
     * Define search filters options
     * TODO: Review and correct before commit!
     *
     * @return array
     */
    protected function defineFilterOptions()
    {
        $result = parent::defineFilterOptions();

        // Calculate recent orders number
        $count = \XLite\Core\Database::getRepo('XLite\Model\Order')->searchRecentOrders(null, true);

        if ($count) {
            $recentOrdersFilter = new \XLite\Model\SearchFilter();
            $recentOrdersFilter->setId('recent');
            $recentOrdersFilter->setName(static::t('Recent orders'));
            $recentOrdersFilter->setSuffix(sprintf('(%d)', $count));
            $result = array('recent' => $recentOrdersFilter) + $result;
        }

        return $result;
    }
}
