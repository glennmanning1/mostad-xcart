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

namespace XLite\View\ItemsList\Model\Payment;

/**
 * Payment transactions items list
 */
class Transaction extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Widget param names
     */
    const PARAM_SEARCH_SUBSTRING = 'substring';
    const PARAM_SEARCH_PUBLIC_ID = 'public_id';
    const PARAM_SEARCH_DATE      = 'date';
    const PARAM_SEARCH_STATUS    = 'status';
    const PARAM_SEARCH_VALUE     = 'value';
    const PARAM_SEARCH_ZIPCODE   = 'zipcode';
    const PARAM_SEARCH_CUSTOMER_NAME = 'customerName';

    /**
     * Sort modes
     *
     * @var   array
     */
    protected $sortByModes = array(
        't.public_id'      => 'Public ID',
        'ordr.orderNumber' => 'Order',
        't.date'           => 'Date',
        't.type'           => 'Type',
        't.status'         => 'Status',
        't.value'          => 'Value',
    );

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'payment_transactions/style.css';

        return $list;
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'payment_transactions/popover.js';

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
            static::PARAM_SEARCH_SUBSTRING => new \XLite\Model\WidgetParam\String('Substring', ''),
            static::PARAM_SEARCH_PUBLIC_ID => new \XLite\Model\WidgetParam\String('Public id', ''),
            static::PARAM_SEARCH_DATE      => new \XLite\Model\WidgetParam\String('Date', ''),
            static::PARAM_SEARCH_STATUS    => new \XLite\Model\WidgetParam\String('Status', ''),
            static::PARAM_SEARCH_VALUE     => new \XLite\Model\WidgetParam\String('Value', ''),
            static::PARAM_SEARCH_ZIPCODE   => new \XLite\Model\WidgetParam\String('Customer zip/postal code', ''),
            static::PARAM_SEARCH_CUSTOMER_NAME => new \XLite\Model\WidgetParam\String('Customer name', ''),
        );
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'public_id' => array(
                static::COLUMN_NAME => static::t('Public id'),
                static::COLUMN_SORT => 't.public_id',
            ),
            'order' => array(
                static::COLUMN_NAME => static::t('Order'),
                static::COLUMN_LINK => 'order',
                static::COLUMN_SORT => 'ordr.orderNumber',
            ),
            'profile' => array(
                static::COLUMN_NAME     => static::t('Customer'),
                static::COLUMN_TEMPLATE => $this->getDir() . '/' . $this->getPageBodyDir() . '/order/cell.profile.tpl',
                static::COLUMN_NO_WRAP  => true,
            ),
            'date' => array(
                static::COLUMN_NAME => static::t('Date'),
                static::COLUMN_SORT => 't.date',
            ),
            'method_name' => array(
                static::COLUMN_NAME => static::t('Method name'),
            ),
            'type' => array(
                static::COLUMN_NAME => static::t('Type'),
                static::COLUMN_SORT => 't.type',
            ),
            'status' => array(
                static::COLUMN_NAME => static::t('Status'),
                static::COLUMN_SORT => 't.status',
                static::COLUMN_TEMPLATE => 'payment_transactions/parts/cell.transaction_status.tpl',
            ),
            'value' => array(
                static::COLUMN_NAME => static::t('Value'),
                static::COLUMN_SORT => 't.value',
            ),
        );
    }

    /**
     * Define line class as list of names
     *
     * @param integer              $index  Line index
     * @param \XLite\Model\AEntity $entity Line model OPTIONAL
     *
     * @return array
     */
    protected function defineLineClass($index, \XLite\Model\AEntity $entity = null)
    {
        $result = parent::defineLineClass($index, $entity);

        if ($entity->getStatus() === \XLite\Model\Payment\Transaction::STATUS_FAILED) {
            $result[] = 'failed-transaction';
        }

        return $result;
    }

    /**
     * Get top actions
     *
     * @return array
     */
    protected function getTopActions()
    {
        $actions = parent::getTopActions();

        $actions[] = 'payment_transactions/parts/not_finished_orders.button.tpl';

        return $actions;
    }

    /**
     * Return order entity for given transaction
     *
     * @param \XLite\Model\Payment\Transaction $entity Transaction entity
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder($entity)
    {
        return $entity->getOrder();
    }

    /**
     * Check - order's profile removed or not
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return boolean
     */
    protected function isProfileRemoved(\XLite\Model\Payment\Transaction $transaction)
    {
        return !$this->getOrder($transaction)
            || !$transaction->getProfile()
            || (
                $this->getOrder($transaction)->getOrigProfile()
                && $this->getOrder($transaction)->getOrigProfile()->getOrder()
            );
    }

    /**
     * Preprocess profile
     *
     * @param mixed                            $profile     Profile
     * @param array                            $column      Column data
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return string
     */
    protected function preprocessProfile($profile, array $column, \XLite\Model\Payment\Transaction $transaction)
    {
        $result = '';

        if ($profile) {
            $address = $profile->getBillingAddress() ?: $profile->getShippingAddress();
            $result = $address ? $address->getName() : $profile->getLogin();
        }

        return $result;
    }

    /**
     * Get default sort order
     *
     * @return string
     */
    protected function getSortOrderModeDefault()
    {
        return static::SORT_ORDER_DESC;
    }

    /**
     * Get default sort mode
     *
     * @return string
     */
    protected function getSortByModeDefault()
    {
        return 't.date';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Payment\Transaction';
    }

    /**
     * Return 'Order by' array.
     * array(<Field to order>, <Sort direction>)
     *
     * @return array
     */
    protected function getOrderBy()
    {
        return array($this->getSortBy(), $this->getSortOrder());
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' payment-transactions';
    }

    /**
     * Check if the column must be a link.
     * It is used if the column field is displayed via
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function isLink(array $column, \XLite\Model\AEntity $entity)
    {
        return parent::isLink($column, $entity)
            && ('order' !== $column[static::COLUMN_CODE] || $this->hasLinkableOrder($entity));
    }

    /*
     * Check if transaction has order, which can be viewed by link
     *
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function hasLinkableOrder(\XLite\Model\AEntity $entity)
    {
        return $this->getOrder($entity)->getOrderNumber();
    }

    /**
     * Build entity page URL
     *
     * @param \XLite\Model\AEntity $entity Entity
     * @param array                $column Column data
     *
     * @return string
     */
    protected function buildEntityURL(\XLite\Model\AEntity $entity, array $column)
    {
        return 'order' === $column[static::COLUMN_CODE]
            ? \XLite\Core\Converter::buildURL(
                $column[static::COLUMN_LINK],
                '',
                array('order_number' => $this->getOrder($entity)->getOrderNumber())
            )
            : parent::buildEntityURL($entity, $column);
    }

    /**
     * Get order
     *
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function getOrderColumnValue(\XLite\Model\Payment\Transaction $entity)
    {
        /** @var \XLite\Model\Order $order */
        $order = $this->getOrder($entity);

        return $order instanceof \XLite\Model\Cart
            ? null
            : $order->getPrintableOrderNumber();
    }

    /**
     * Get method name
     *
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function getMethodNameColumnValue(\XLite\Model\Payment\Transaction $entity)
    {
        return $entity->getPaymentMethod()
            ? $entity->getPaymentMethod()->getName()
            : $entity->getMethodName();
    }

    /**
     * Preprocess date
     *
     * @param float                            $value  Status code
     * @param array                            $column Column info
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function preprocessDate($value, array $column, \XLite\Model\Payment\Transaction $entity)
    {
        return static::formatTime($value);
    }

    /**
     * Preprocess status
     *
     * @param string                           $value  Status code
     *
     * @return string
     */
    protected function getHumanStatus($value)
    {
        $list = \XLite\Model\Payment\Transaction::getStatuses();

        return static::t($list[$value].'[S]');
    }

    /**
     * Is failed transactions status popover visible
     *
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return boolean
     */
    protected function isTransactionStatusPopoverVisible(\XLite\Model\Payment\Transaction $entity)
    {
        return !$entity->getTransactionData()->isEmpty();
    }

    /**
     * Failed transactions status popover
     *
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function getTransactionStatusPopoverContent(\XLite\Model\Payment\Transaction $entity)
    {
        return $this->getWidget(array('entity' => $entity), '\XLite\View\FailedTransactionTooltip')->getContent();
    }

    /**
     * Failed transactions status popover
     *
     * @return string
     */
    protected function getTransactionStatusPopoverTitle()
    {
        return static::t('Details');
    }


    /**
     * Preprocess type
     *
     * @param string                           $value  Status code
     * @param array                            $column Column info
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function preprocessType($value, array $column, \XLite\Model\Payment\Transaction $entity)
    {
        $list = \XLite\Model\Payment\BackendTransaction::getTypes();

        return static::t($list[$value] . '[TT]');
    }

    /**
     * Preprocess value
     *
     * @param float                            $value  Status code
     * @param array                            $column Column info
     * @param \XLite\Model\Payment\Transaction $entity Payment transaction
     *
     * @return string
     */
    protected function preprocessValue($value, array $column, \XLite\Model\Payment\Transaction $entity)
    {
        return static::formatPrice($value, $entity->getCurrency());
    }

    /**
     * Get panel class
     *
     * @return \XLite\View\Base\FormStickyPanel
     */
    protected function getPanelClass()
    {
        return null;
    }

    /**
     * Get main column
     *
     * @return array
     */
    protected function getMainColumn()
    {
        return null;
    }

    // {{{ Search

    /**
     * Return search parameters.
     *
     * @return array
     */
    public static function getSearchParams()
    {
        return array(
            \XLite\Model\Repo\Payment\Transaction::SEARCH_SUBSTRING => static::PARAM_SEARCH_SUBSTRING,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_PUBLIC_ID => static::PARAM_SEARCH_PUBLIC_ID,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_DATE      => static::PARAM_SEARCH_DATE,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_STATUS    => static::PARAM_SEARCH_STATUS,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_VALUE     => static::PARAM_SEARCH_VALUE,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_ZIPCODE   => static::PARAM_SEARCH_ZIPCODE,
            \XLite\Model\Repo\Payment\Transaction::SEARCH_CUSTOMER_NAME => static::PARAM_SEARCH_CUSTOMER_NAME,
        );
    }

    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();
        $this->requestParams[] = static::PARAM_SEARCH_SUBSTRING;
        $this->requestParams[] = static::PARAM_SEARCH_PUBLIC_ID;
        $this->requestParams[] = static::PARAM_SEARCH_DATE;
        $this->requestParams[] = static::PARAM_SEARCH_STATUS;
        $this->requestParams[] = static::PARAM_SEARCH_VALUE;
        $this->requestParams[] = static::PARAM_SEARCH_ZIPCODE;
        $this->requestParams[] = static::PARAM_SEARCH_CUSTOMER_NAME;
    }

    /**
     * Return params list to use for search
     * TODO refactor
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $result->{\XLite\Model\Repo\Payment\Transaction::SEARCH_ORDERBY} = $this->getOrderBy();

        foreach (static::getSearchParams() as $modelParam => $requestParam) {
            $paramValue = $this->getParam($requestParam);

            if ('' !== $paramValue && 0 !== $paramValue) {
                $result->$modelParam = $paramValue;
            }
        }

        return $result;
    }

    // }}}
}
