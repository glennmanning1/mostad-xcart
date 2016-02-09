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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper\ConfirmOrder;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;
use \XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper;

/**
 * Get quote input mapper
 */
class InputMapper extends API\Mapper\JsonPostProcessedMapper
{
    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    protected function isApplicable()
    {
        return $this->inputData && $this->inputData instanceof \XLite\Module\XC\PitneyBowes\Model\PBOrder;
    }

    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    protected function performMap()
    {
        $confirm = array();

        $confirm['transactionId']           = $this->inputData->getTransactionId();
        $confirm['merchantOrderNumber']     = $this->inputData->getOrder()->getOrderNumber(); // TODO OrderId or OrderNumber?
        $confirm['purchaser']               = $this->getPurchaser();
        $confirm['purchaserBillingAddress'] = $this->getPurchaserBillingAddress();

        return $confirm;
    }

    /**
     * Postprocess mapped data
     * 
     * @return array
     */
    protected function getPurchaser()
    {
        $consignee = null;

        $profile = $this->inputData->getOrder()->getProfile();
        if ($profile) {
            $address = $profile->getBillingAddress() ?: $profile->getShippingAddress();

            $consignee = array(
                'familyName'    => $address->getLastname(),
                'givenName'     => $address->getFirstname(),
                'email'         => $profile->getLogin()
            );

            if ($address->getPhone()) {
                $consignee['phoneNumbers']  = array(
                    array(
                        'number'    => $address->getPhone(),
                        'type'      => 'other'
                    ),
                );
            } elseif (\XLite\Core\Config::getInstance()->Company->company_phone) {
                $consignee['phoneNumbers']  = array(
                    array(
                        'number'    => \XLite\Core\Config::getInstance()->Company->company_phone,
                        'type'      => 'other'
                    ),
                );
            }
        }

        return $consignee;
    }

    /**
     * Postprocess mapped data
     * 
     * @return array
     */
    protected function getPurchaserBillingAddress()
    {
        $modifierModel = $this->inputData->getOrder()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        $modifierLogicModel = $modifierModel->getModifier();
        $dstAddress = \XLite\Model\Shipping::getInstance()->getDestinationAddress($modifierLogicModel);

        return $this->getShippingAdressByDstAddressArray($dstAddress);
    }

    /**
     * Retrieve shipping adress from dstAddress
     * 
     * @return array
     */
    protected function getShippingAdressByDstAddressArray(array $dstAddress)
    {
        $state = null;
        if (
            $dstAddress['state']
            && is_numeric($dstAddress['state'])
        ) {
            $stateObject = \XLite\Core\Database::getRepo('XLite\Model\State')->find($dstAddress['state']);
            if ($stateObject) {
                $state = $stateObject->getCode();
            }
        } elseif ($dstAddress['custom_state']) {
            $state = $dstAddress['custom_state'];
        }

        if (!$state) {
            \XLite\Logger::logCustom("PitneyBowes", 'Problem with state', false);
        }

        return array(
            'street1'           => $dstAddress['address'] ?: '',
            'city'              => $dstAddress['city'],
            'provinceOrState'   => $state,
            'country'           => $dstAddress['country'],
            'postalOrZipCode'   => $dstAddress['zipcode'],
        );
    }

}
