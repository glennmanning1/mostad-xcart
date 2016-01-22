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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\API\Request\Stub;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;

/**
 * https://wiki.ecommerce.pb.com/display/TECH4/Get+Quote
 */
class GetQuoteRequest extends API\Request\GetQuoteRequest
{
    protected $body = '{
          "quoteCurrency": "USD",
          "fxRatesUsed": [],
          "transactionId": "123456789",
          "totalCommodity": {
            "value": "8.99",
            "currency": "USD"
          },
          "totalTransportation": {
            "currency": "USD",
            "merchantShippingIdentifier": "STANDARD",
            "speed": "STANDARD",
            "shipping": {
              "value": "10.99",
              "currency": "USD"
            },
            "handling": {
              "value": "4.00",
              "currency": "USD"
            },
            "total": {
              "value": "14.99",
              "currency": "USD"
            },
            "minDays": 3,
            "maxDays": 5
          },
          "totalImportation": {
            "importationCurrency": "USD",
            "approximateDuty": {
              "value": "4.00",
              "currency": "USD"
            },
            "approximateTax": {
              "value": "5.00",
              "currency": "USD"
            },
            "approximateBrokerage": {
              "value": "1.00",
              "currency": "USD"
            },
            "total": {
              "value": "10.00",
              "currency": "USD"
            }
          },
          "total": {
            "value": "15.67",
            "currency": "USD"
          },
          "errors": []
    }';

    /**
     * 
     */
    public function getResponse()
    {
        $this->response = new \PEAR2\HTTP\Request\Response(
            array(),
            $this->body,
            array(),
            array()
        );

        return parent::getResponse();
    }
}
