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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper\GetQuote;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;
use \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor;

/**
 * Get quote input mapper
 */
class ModifierInputMapper extends API\Mapper\JsonPostProcessedMapper
{
    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    protected function isApplicable()
    {
        return $this->inputData && $this->inputData instanceof \XLite\Logic\Order\Modifier\Shipping;
    }

    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    protected function performMap()
    {
        $dstAddress = \XLite\Model\Shipping::getInstance()->getDestinationAddress($this->inputData);

        if (!Processor\PitneyBowes::isCountryApplicable($dstAddress['country'])) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
                $dstAddress['country'] . ' is not an applicable country'
            );
            return null;
        }
        $basket = new API\DataTypes\Basket();

        $basket->merchantId             = $this->config->merchant_code;
        $basket->basketCurrency         = $this->inputData->getOrder()->getCurrency()->getCode();
        $basket->quoteCurrency          = $this->inputData->getOrder()->getCurrency()->getCode();

        $consignee = $this->getConsignee();
        if (null !== $consignee) {
            $basket->consignee = $consignee;
        } else {
            unset($basket->consignee);
        }

        $basket->shippingAddress        = $this->getShippingAdress();

        foreach ($this->inputData->getItems() as $orderItem) {
            $basket->basketLines[] = $this->getBasketLine($orderItem);
        }

        $basket->toHubTransportations[] = $this->getToHubTransportation();

        $basket->parcels = $this->getParcels();

        return $basket;
    }

    /**
     * Returns array of data for request
     *
     * @return array
     */
    protected function getParcels()
    {
        $packages = array();
        // TODO Implement it maybe
        return $packages;
    }

    /**
     * @param \XLite\Model\OrderItem $orderItem Order item
     * 
     * @return array
     */
    protected function getBasketLine(\XLite\Model\OrderItem $orderItem)
    {
        return array(
            'lineId'        => $orderItem->getSku(),
            'currency'      => $orderItem->getOrder()->getCurrency()->getCode(),
            'quantity'      => $orderItem->getAmount(),
            'unitPrice'     => array(
                'price'         => array('value' => $orderItem->getItemNetPrice()),
                'codPrice'      => array(),
                'dutiableValue' => array('value' => $orderItem->getItemNetPrice()),
            ),
            'commodity'     => array(
                'merchantComRefId'      => $orderItem->getSku(),
                'descriptions'          => array(),
                'hsCodes'               => array(),
                'imageUrls'             => array(),
                'identifiers'           => array(),
                'attributes'            => array(),
                'hazmats'               => array(),
                'categories'            => array(),
            ),
            'kitContents'   => array(),
        );
    }

    /**
     * toHubTransportation part of basket
     * 
     * @return array
     */
    protected function getToHubTransportation()
    {
        $handlingFee = Processor\PitneyBowes::getHandlingFeeMarkup(
            count($this->inputData->getItems())
        );

        $shippingFee = Processor\PitneyBowes::getShippingFeeMarkup(
            count($this->inputData->getItems())
        );

        return array(
            'merchantShippingIdentifier'            => 'STANDARD',
            'speed'                                 => 'STANDARD',
            'shipping'           => array('value' => $handlingFee),
            'handling'           => array('value' => $shippingFee),
            'total'              => array('value' => $shippingFee + $handlingFee),
            'minDays'            => intval($this->config->min_delivery_adjustment),
            'maxDays'            => intval($this->config->max_delivery_adjustment),
        );
    }

    /**
     * Retrieve shipping adress from modifier
     * 
     * @return array
     */
    protected function getShippingAdress()
    {
        $dstAddress = \XLite\Model\Shipping::getInstance()->getDestinationAddress($this->inputData);

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

    /**
     * Retrieve consignee from modifier
     * 
     * @return array
     */
    protected function getConsignee()
    {
        $consignee = null;

        $profile = $this->inputData->getOrder()->getProfile();
        if ($profile) {
            $address = $profile->getBillingAddress() ?: $profile->getShippingAddress();
            if ($address) {
                $consignee = array(
                    'familyName'    => $address->getLastname(),
                    'givenName'     => $address->getFirstname(),
                    'email'         => $profile->getLogin(),
                    'phoneNumbers'  => array(
                        array(
                            'number' => $address->getPhone(),
                            'type' => 'other'
                        ),
                    ),
                );
            }
        }

        return $consignee;
    }
}
