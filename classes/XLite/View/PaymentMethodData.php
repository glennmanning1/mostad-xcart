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

namespace XLite\View;

/**
 * Payment method data (saved with order) modification (usage: AOM)
 */
class PaymentMethodData extends \XLite\View\AView
{
    /**
     * Cached processor
     *
     * @var \XLite\Model\Payment\Base\Processor
     */
    protected $processor = null;

    /**
     * Get default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'payment_method_data/body.tpl';
    }

    /**
     * Get container attributes 
     * 
     * @return array
     */
    protected function getContainerAttributes()
    {
        $attributes = array(
            'class' => array('order-payment-data-dialog'),
        );

        return $attributes;
    }

    /**
     * Get transaction ID
     *
     * @return integer
     */
    protected function getTransactionId()
    {
        return (int) \XLite\Core\Request::getInstance()->transaction_id;
    }

    /**
     * Get list of field values
     *
     * @return array
     */
    protected function getFieldValues()
    {
        $result = array();

        $transactionId = $this->getTransactionId();

        $transaction = $transactionId
            ? \XLite\Core\Database::getRepo('\XLite\Model\Payment\Transaction')->find($transactionId)
            : null;

        if (
            $transaction
            && $transaction->getPaymentMethod()
            && $transaction->getPaymentMethod()->getProcessor()
        ) {
            $transactionData = $transaction->getPaymentMethod()->getProcessor()->getTransactionData($transaction);

            if ($transactionData) {

                $prefix = 'transaction-' . $transaction->getTransactionId();

                $requestData = \XLite\Core\Request::getInstance()->$prefix;

                foreach($transactionData as $data) {

                    $result[] = array(
                        'name' => 'orig-' . $data['name'],
                        'value' => isset($requestData[$data['name']])
                                ? $requestData[$data['name']]
                                : $data['value'],
                    );
                }
            }
        }

        return $result;
    }
}
