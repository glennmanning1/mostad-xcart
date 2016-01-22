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
 * https://wiki.ecommerce.pb.com/display/TECH4/Create+Order
 */
class CreateOrderRequest extends API\Request\CreateOrderRequest
{
    protected $body = '{"order": [{
       "orderId": "ORMUSP11120562GB",
       "order":    {
          "quoteCurrency": "USD",
          "transactionId": "22",
          "quoteLines": [      {
             "lineId": "65",
             "merchantComRefId": "0-12345600",
             "quoteLineId": "1",
             "quantity": 1,
             "unitPrice":          {
                "value": 600,
                "currency": "USD"
             },
             "unitImportation":          {
                "importationCurrency": "USD",
                "approximateDuty":             {
                   "value": 60.04,
                   "currency": "USD"
                },
                "approximateTax":             {
                   "value": 135.8,
                   "currency": "USD"
                },
                "approximateBrokerage":             {
                   "value": 1.51,
                   "currency": "USD"
                },
                "total":             {
                   "value": 197.35,
                   "currency": "USD"
                }
             },
             "unitTransportation":          {
                "currency": "USD",
                "merchantShippingIdentifier": "STANDARD",
                "speed": "STANDARD",
                "shipping":             {
                   "value": 13.85,
                   "currency": "USD"
                },
                "handling":             {
                   "value": 2.01,
                   "currency": "USD"
                },
                "total":             {
                   "value": 15.86,
                   "currency": "USD"
                },
                "minDays": 4,
                "maxDays": 7
             },
             "unitTotal":          {
                "value": 213.21,
                "currency": "USD"
             },
             "linePrice":          {
                "value": 600,
                "currency": "USD"
             },
             "lineImportation":          {
                "importationCurrency": "USD",
                "approximateDuty":             {
                   "value": 60.04,
                   "currency": "USD"
                },
                "approximateTax":             {
                   "value": 135.8,
                   "currency": "USD"
                },
                "approximateBrokerage":             {
                   "value": 1.51,
                   "currency": "USD"
                },
                "total":             {
                   "value": 197.35,
                   "currency": "USD"
                }
             },
             "lineTransportation":          {
                "currency": "USD",
                "merchantShippingIdentifier": "STANDARD",
                "speed": "STANDARD",
                "shipping":             {
                   "value": 13.85,
                   "currency": "USD"
                },
                "handling":             {
                   "value": 2.01,
                   "currency": "USD"
                },
                "total":             {
                   "value": 15.86,
                   "currency": "USD"
                },
                "minDays": 4,
                "maxDays": 7
             },
             "lineTotal":          {
                "value": 213.21,
                "currency": "USD"
             }
          }],
          "totalCommodity":       {
             "value": 600,
             "currency": "USD"
          },
          "totalTransportation":       {
             "currency": "USD",
             "merchantShippingIdentifier": "STANDARD",
             "speed": "STANDARD",
             "shipping":          {
                "value": 13.85,
                "currency": "USD"
             },
             "handling":          {
                "value": 2.01,
                "currency": "USD"
             },
             "total":          {
                "value": 15.86,
                "currency": "USD"
             },
             "minDays": 4,
             "maxDays": 7
          },
          "totalImportation":       {
             "importationCurrency": "USD",
             "approximateDuty":          {
                "value": 60.04,
                "currency": "USD"
             },
             "approximateTax":          {
                "value": 135.8,
                "currency": "USD"
             },
             "approximateBrokerage":          {
                "value": 1.51,
                "currency": "USD"
             },
             "total":          {
                "value": 197.35,
                "currency": "USD"
             }
          },
          "total":       {
             "value": 213.21,
             "currency": "USD"
          }
       },
       "status":    {
          "confirmed": false,
          "canceled": false,
          "held": false,
          "itemsShipped": 0
       },
       "expireDate": "2015-08-12T14:52:35-04:00",
       "shipToHub":    {
          "hubId": "US_ELOVATIONS_KY",
          "hubAddress":       {
             "street1": "1850 Airport Exchange Boulevard",
             "street2": "Order#: ORMUSP11120562GB",
             "city": "Erlanger",
             "provinceOrState": "Kentucky",
             "postalOrZipCode": "41025-2501",
             "country": "US"
          }
       }
    }]}';

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
