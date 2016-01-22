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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper\CreateInboundParcels;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;
use \XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper;

/**
 * Get quote input mapper
 */
class InputMapper extends API\Mapper\JsonPostProcessedMapper
{
    /**
     * @var \XLite\Module\XC\PitneyBowes\Model\PBParcel      Input pitney bowes parcel
     */
    protected $pbParcel;

    /**
     * @var \XLite\Core\Request                             Input request data
     */
    protected $request;

    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    protected function isApplicable()
    {
        return $this->inputData 
            && is_array($this->inputData)
            && isset($this->inputData['pbParcel']) && $this->inputData['pbParcel'] instanceof \XLite\Module\XC\PitneyBowes\Model\PBParcel
            && isset($this->inputData['request'])  && $this->inputData['request'] instanceof \XLite\Core\Request;
    }
    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    protected function performMap()
    {
        $request = array();

        $this->pbParcel = $this->inputData['pbParcel'];
        $this->request = $this->inputData['request'];

        $request['merchantOrderNumber']         = $this->pbParcel->getOrder()->getOrmus();
        $request['parcelIdentificationNumber']  = $this->pbParcel->getNumber();
        $request['inboundParcelCommodities']    = $this->getInboundParcelCommodities();
        $request['shipperTrackingNumber']       = $this->pbParcel->getNumber();
        $request['returnDetails']               = $this->getReturnDetails();

        $request['size'] = $this->getTotalSize($request['inboundParcelCommodities']);

        return $request;
    }

    /**
     * Get total size
     * 
     * @param array $commodities List of commodities in parcel
     * 
     * @return array
     */
    protected function getTotalSize(array $commodities)
    {
        $weight = 0;

        foreach ($commodities as $commodity) {
            $weight += $commodity['quantity'] * $commodity['size']['weight'];
        }

        return array(
            'weight'        => $weight,
            'weightUnit'    => $this->getWeightUnit(),
        );
    }

    /**
     * Get commodities list
     * 
     * @return array
     */
    protected function getInboundParcelCommodities()
    {
        $commodities = array();

        foreach ($this->pbParcel->getParcelItems() as $parcelItem) {
            $commodities[] = $this->getInboundParcelCommodity($parcelItem);
        }

        return $commodities;
    }

    /**
     * Get commodity
     * 
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel $parcelItem Parcel item
     * 
     * @return array
     */
    protected function getInboundParcelCommodity($parcelItem)
    {
        $orderItem = $parcelItem->getOrderItem();

        return array(
            "merchantComRefId"  => $orderItem->getSku(),
            "quantity"          => $parcelItem->getAmount(),
            "size"  => array(
                "weight"        => $orderItem->getWeight(),
                "weightUnit"    => $this->getWeightUnit(),
            )
        );
    }

    /**
     * Get return details
     * 
     * @return array
     */
    protected function getReturnDetails()
    {
        return array(
            'returnAddress'         => $this->getReturnAddress(),
            'contactInformation'    => $this->getReturnContactInformation(),
        );
    }

    /**
     * Get return details address
     * 
     * N.B. Currently returns company address defined in "Store setup" -> "Contact information"
     * 
     * @return array
     */
    protected function getReturnAddress()
    {
        return array(
            'street1'           => \XLite\Core\Config::getInstance()->Company->location_country,
            'city'              => \XLite\Core\Config::getInstance()->Company->location_city,
            'provinceOrState'   => \XLite\Core\Config::getInstance()->Company->location_state,
            'country'           => \XLite\Core\Config::getInstance()->Company->location_country,
            'postalOrZipCode'   => \XLite\Core\Config::getInstance()->Company->location_zipcode,
        );
    }

    /**
     * Get return details address
     * 
     * N.B. Currently returns current logged admin contact information
     * 
     * @return array
     */
    protected function getReturnContactInformation()
    {
        $profile = \XLite\Core\Auth::getInstance()->getProfile();

        $address = $profile->getBillingAddress() ?: $profile->getShippingAddress();

        if (!$address || !$address->getLastname()) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
                'Cannot call createASN without vendor\'s address specified'
            );
            return null;
        }

        return array(
            'familyName'    => $address->getLastname(),
            'givenName'     => $address->getFirstname(),
            'email'         => $profile->getLogin(),
            'phoneNumbers'  => array(
                array(
                    'number'    => $address->getPhone(),
                    'type'      => 'other',
                )
            ),
        );
    }

    /**
     * Get weight unit
     * 
     * @return string
     */
    protected function getWeightUnit()
    {
        return \XLite\Core\Config::getInstance()->Units->weight_unit == 'lbs'
            ? 'lb'
            : \XLite\Core\Config::getInstance()->Units->weight_unit;
    }
}
