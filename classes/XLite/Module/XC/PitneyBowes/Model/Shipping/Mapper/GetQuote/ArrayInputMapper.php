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
class ArrayInputMapper extends ModifierInputMapper
{
    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    protected function isApplicable()
    {
        return $this->inputData && is_array($this->inputData);
    }

    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    protected function performMap()
    {
        $basket = new API\DataTypes\Basket();

        $basket->merchantId             = $this->config->merchant_code;
        $basket->basketCurrency         = \XLite::getInstance()->getCurrency()->getCode();
        $basket->quoteCurrency          = \XLite::getInstance()->getCurrency()->getCode();

        // $consignee = $this->getConsignee();
        // if (null !== $consignee) {
        //     $basket->consignee = $consignee;
        // } else {
        //     unset($basket->consignee);
        // }

        $firstPackage = reset($this->inputData['packages']);
        $basket->shippingAddress        = $this->getShippingAdress();

        $basket->basketLines[] = $this->getBasketLineByCommodity($firstPackage['commodity'] );

        $basket->toHubTransportations[] = $this->getToHubTransportation();

        $basket->parcels = $this->getParcels();

        return $basket;
    }


    /**
     * toHubTransportation part of basket
     * 
     * @return array
     */
    protected function getToHubTransportation()
    {
        $handlingFee = Processor\PitneyBowes::getHandlingFeeMarkup(
            count($this->inputData)
        );

        $shippingFee = Processor\PitneyBowes::getShippingFeeMarkup(
            count($this->inputData)
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
     * @param string $id Product id
     * 
     * @return array
     */
    protected function getBasketLineByCommodity($id)
    {
        $product = \XLite\Core\Database::getRepo('\XLite\Model\Product')->find($id);
        return array(
            'lineId'        => $product->getSku(),
            'currency'      => \XLite::getInstance()->getCurrency()->getCode(),
            'quantity'      => 1,
            'unitPrice'     => array(
                'price'         => array('value' => $product->getPrice()),
                'codPrice'      => array(),
                'dutiableValue' => array('value' => $product->getPrice()),
            ),
            'commodity'     => array(
                'merchantComRefId'      => $product->getSku(),
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
     * Retrieve shipping adress from modifier
     * 
     * @return array
     */
    protected function getShippingAdress()
    {
        $firstPackage = reset($this->inputData['packages']);
        $dstAddress = $firstPackage['dstAddress'];

        return $this->getShippingAdressByDstAddressArray($dstAddress);
    }

    /**
     * Postprocess mapped data
     * 
     * @param mixed $mapped mapped data to postprocess
     * 
     * @return mixed
     */
    protected function postProcessMapped($mapped)
    {
        unset($mapped->consignee);

        return parent::postProcessMapped($mapped);
    }
}
