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
 * Get quote output mapper
 */
class OutputMapper extends API\Mapper\AMapper
{
    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    protected function isApplicable()
    {
        return $this->inputData && $this->inputData instanceof \PEAR2\HTTP\Request\Response;
    }

    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    protected function performMap()
    {
        $response = json_decode($this->inputData->body);

        $rates = array();
        if (isset($response->quote)) {
            foreach ($response->quote as $quote) {
                $rates[] = $this->mapSingleQuote($quote);
            }
        } elseif (isset($response->error)) {
            \XLite\Logger::logCustom("PitneyBowes", $response->error . ':' . $response->message, false);
        }

        return $rates;
    }

    /**
     * Get total cost for base rate
     * 
     * @param mixed $quote Single quote line
     * 
     * @return float
     */
    protected function getBaseRate($quote)
    {
        $baseRate = $quote->total->value;

        if (
            $this->getAdditionalData('requested')
            && $this->getAdditionalData('requested') instanceof \XLite\Logic\Order\Modifier\Shipping
        ) {
            $order = $this->getAdditionalData('requested')->getOrder();
            $address = \XLite\Model\Shipping::getInstance()->getDestinationAddress($this->getAdditionalData('requested'));

            $baseRate = Processor\PitneyBowes::getFullTransportationCost(
                $order->getSubtotal(),
                $address['country'],
                $quote
            );
        }

        return $baseRate;
    }


    /**
     * Map single quote
     * 
     * @param mixed $quote Single quote line
     * 
     * @return \XLite\Model\Shipping\Rate
     */
    protected function mapSingleQuote($quote)
    {
        $rate = null;
        if (isset($quote->total->value)) {
            $rate = new \XLite\Model\Shipping\Rate();
            $rate->setBaseRate(
                $this->getBaseRate($quote)
            );

            $method = Processor\PitneyBowes::getMethod(
                $this->getMethodCode($quote)
            );
            $rate->setMethod($method);
            $rate->setMarkupRate($this->getMarkupRate($quote));

            if (isset($quote->totalTransportation->minDays) || isset($quote->totalTransportation->maxDays)) {
                $extraData = new \XLite\Core\CommonCell();

                $extraData->deliveryMinDays = $quote->totalTransportation->minDays + intval($this->config->min_delivery_adjustment);
                $extraData->deliveryMaxDays = $quote->totalTransportation->maxDays + intval($this->config->max_delivery_adjustment);

                $rate->setExtraData($extraData);
            }
        }
        if (isset($quote->errors)) {
            foreach ($quote->errors as $error) {
                \XLite\Logger::logCustom("PitneyBowes", $error->error, false);
            }
        }
        return $rate;
    }

    /**
     * 
     * @param mixed $quote Single quote line
     * 
     * @return float
     */
    protected function getMarkupRate($quote)
    {
        $handlingFee = Processor\PitneyBowes::getHandlingFeeMarkup(
            count($quote->quoteLines)
        );

        $shippingFee = Processor\PitneyBowes::getShippingFeeMarkup(
            count($quote->quoteLines)
        );

        return $handlingFee + $shippingFee;
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
        return array_filter($mapped);
    }

    /**
     * Get shipping method code for rate
     * N.B. There is only one code currently,
     * but later we will determine which to use by getQuote response
     * 
     * @param mixed $response Response parsed from json
     * 
     * @return string
     */
    protected function getMethodCode($response)
    {
        return 'PB_INTERNATIONAL';
    }
}