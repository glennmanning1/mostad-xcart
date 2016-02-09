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

namespace XLite\Model\Payment\Processor;

/**
 * E-check
 */
class Check extends \XLite\Model\Payment\Processor\Offline
{
    /**
     * Get input template
     *
     * @return string|void
     */
    public function getInputTemplate()
    {
        return 'checkout/echeck.tpl';
    }

    /**
     * Check - display check number or not
     *
     * @return boolean
     */
    public function isDisplayNumber()
    {
        return \XLite\Core\Config::getInstance()->General->display_check_number;
    }


    /**
     * Get input data labels list
     *
     * @return array
     */
    protected function getInputDataLabels()
    {
        return array(
            'check_routing_number' => 'ABA routing number',
            'check_acct_number'    => 'Bank Account Number',
            'check_type'           => 'Type of Account',
            'check_bank_name'      => 'Name of bank at which account is maintained',
            'check_acct_name'      => 'Name under which the account is maintained at the bank',
            'check_number'         => 'Check number',
        );
    }

    /**
     * Get input data access levels list
     *
     * @return array
     */
    protected function getInputDataAccessLevels()
    {
        return array(
            'check_routing_number' => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
            'check_acct_number'    => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
            'check_type'           => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
            'check_bank_name'      => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
            'check_acct_name'      => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
            'check_number'         => \XLite\Model\Payment\TransactionData::ACCESS_ADMIN,
        );
    }
}
