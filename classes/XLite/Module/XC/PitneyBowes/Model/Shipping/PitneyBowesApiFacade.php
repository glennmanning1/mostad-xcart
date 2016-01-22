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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;
use \XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper;

/**
 * PitneyBowesApi
 * API documentation: https://wiki.ecommerce.pb.com/display/TECH4/Pitney+Bowes+Ecommerce+-+Technical+Wiki
 *
 */
class PitneyBowesApiFacade
{
    /**
     * @var string Auth token
     */
    protected $auth;

    /**
     * 
     */
    function __construct($config)
    {
        $this->config = $config;
    }

    protected function getAuth()
    {
        if (null === $this->auth) {
            $this->auth = $this->authToken();
        }
        return $this->auth;
    }

    protected static function getApiURL($config, $name)
    {
        return $config->test_mode
            ? $config->{$name.'_test'}
            : $config->{$name};
    }

    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Auth+Token
     * 
     * @return AuthToken
     */
    public function authToken()
    {
        $url = static::getApiURL($this->config, 'token_api_endpoint');

        $request = new API\Request\AuthTokenRequest($url, array());
        $request->setOutputMapper(new API\Mapper\AuthTokenMapper($this->config));

        $authBase64 = base64_encode(
            sprintf('%s:%s', $this->config->api_username, $this->config->api_password)
        );

        $request->setAuth('Basic', $authBase64);
        $request->sendRequest();

        \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
            'Auth API called with: ' . PHP_EOL
            . 'URL: ' . $url . PHP_EOL
            . 'Request: ' . var_export($request->getRawRequest(), true) . PHP_EOL
            . 'Response: '. $request->getRawResponse() . PHP_EOL
        );

        return $request->getResponse();
    }

    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Get+Quote
     * 
     * @return QuoteSet
     */
    public function getQuote($inputData)
    {
        $url = static::getApiURL($this->config, 'checkout_api_endpoint') . '/quotes';

        $request = new API\Request\GetQuoteRequest($url, $inputData);

        $inputMapper = new Mapper\GetQuote\ModifierInputMapper($this->config);
        $inputMapper->setNextMapper(new Mapper\GetQuote\ArrayInputMapper($this->config));
        $request->setInputMapper($inputMapper);

        $request->setOutputMapper(new Mapper\GetQuote\OutputMapper($this->config));

        $auth = $this->getAuth();
        $request->setAuth($auth['type'], $auth['value']);

        $request->sendRequest();

        \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
            'getQuote API called with: ' . PHP_EOL
            . 'URL: ' . $url . PHP_EOL
            . 'Cache hash: '. $this->getQuoteCacheKey($inputData) . PHP_EOL
            . 'Request: ' . var_export($request->getRawRequest(), true) . PHP_EOL
            . 'Response: '. $request->getRawResponse() . PHP_EOL
        );

        return $request->getResponse();
    }

    /**
     * @return string
     */
    public function getQuoteCacheKey($inputData)
    {
        $inputMapper = new Mapper\GetQuote\ModifierInputMapper($this->config);
        $inputMapper->setNextMapper(new Mapper\GetQuote\ArrayInputMapper($this->config));
        $inputMapper->setInputData($inputData);

        $prefix = $inputData instanceof \XLite\Logic\Order\Modifier\Shipping
            ? $inputData->getOrder()->getOrderId()
            : '';

        return $prefix . md5($inputMapper->getMapped()) . md5(serialize($this->config));
    }

    /**
     * @return string
     */
    public function createOrderCacheKey($inputData)
    {
        $inputMapper = new Mapper\CreateOrder\ModifierInputMapper($this->config);
        $inputMapper->setInputData($inputData);

        $prefix = $inputData instanceof \XLite\Logic\Order\Modifier\Shipping
            ? $inputData->getOrder()->getOrderId()
            : '';

        return $prefix . md5($inputMapper->getMapped()) . md5(serialize($this->config));
    }

    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Create+Order
     * 
     * @return OrderSet
     */
    public function createOrder($inputData)
    {
        $url = static::getApiURL($this->config, 'checkout_api_endpoint') . '/orders';

        $request = new API\Request\CreateOrderRequest($url, $inputData);

        $inputMapper = new Mapper\CreateOrder\ModifierInputMapper($this->config);
        $request->setInputMapper($inputMapper);

        $request->setOutputMapper(new Mapper\CreateOrder\OutputMapper($this->config));

        $auth = $this->getAuth();
        $request->setAuth($auth['type'], $auth['value']);

        $request->sendRequest();

        \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
            'createOrder API called with: ' . PHP_EOL
            . 'URL: ' . $url . PHP_EOL
            . 'Request: ' . $request->getRawRequest() . PHP_EOL
            . 'Response: '. $request->getRawResponse() . PHP_EOL
        );

        return $request->getResponse();
    }

    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Confirm+Order
     * 
     * @param \XLite\Module\XC\PitneyBowes\Model\PBOrder
     * 
     * @return mixed
     */
    public function confirmOrder(\XLite\Module\XC\PitneyBowes\Model\PBOrder $inputData)
    {
        $url = static::getApiURL($this->config, 'checkout_api_endpoint') . '/orders/' . $inputData->getOrmus() . '/confirm';

        $request = new API\Request\ConfirmOrderRequest($url, $inputData);

        $inputMapper = new Mapper\ConfirmOrder\InputMapper($this->config);
        $request->setInputMapper($inputMapper);

        $request->setOutputMapper(new Mapper\ConfirmOrder\OutputMapper($this->config));

        $auth = $this->getAuth();
        $request->setAuth($auth['type'], $auth['value']);

        $request->sendRequest();

       \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
            'confirmOrder API called with: ' . PHP_EOL
            . 'URL: ' . $url . PHP_EOL
            . 'Request: ' . $request->getRawRequest() . PHP_EOL
            . 'Response: '. $request->getRawResponse() . PHP_EOL
        );

        return $request->getResponse();
    }

    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Create+Inbound+Parcels
     * 
     * @param array $inputData
     * 
     * @return mixed
     */
    public function createInboundParcelsRequest(array $inputData)
    {
        if (!isset($inputData['pbParcel'])) {
            return null;
        }
        $url = static::getApiURL($this->config, 'asn_endpoint') . '/orders/' . $inputData['pbParcel']->getOrder()->getOrmus() . '/inbound-parcels';

        $request = new API\Request\CreateInboundParcelsRequest($url, $inputData);

        $inputMapper = new Mapper\CreateInboundParcels\InputMapper($this->config);
        $request->setInputMapper($inputMapper);

        $request->setOutputMapper(new Mapper\CreateInboundParcels\OutputMapper($this->config));

        $auth = $this->getAuth();
        $request->setAuth($auth['type'], $auth['value']);

        $request->sendRequest();

        \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
            'createInboundParcels API called with: ' . PHP_EOL
            . 'URL: ' . $url . PHP_EOL
            . 'Request: ' . $request->getRawRequest() . PHP_EOL
            . 'Response: '. $request->getRawResponse() . PHP_EOL
        );

        return $request->getResponse();
    }
}