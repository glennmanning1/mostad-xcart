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

namespace XLite\Module\XC\UPS\Model\Shipping\API;

use XLite\Module\XC\UPS\Model\Shipping\Mapper;
use XLite\Module\XC\UPS\Model\Shipping\Processor;

class UPS
{
    /**
     * @var Processor\UPS
     */
    protected $processor;

    /**
     * @param Processor\UPS $processor
     */
    public function __construct($processor)
    {
        $this->processor = $processor;
    }

    /**
     * Returns API endpoint
     *
     * @return string
     */
    protected function getApiURL()
    {
        return $this->processor->isTestMode()
            ? 'https://wwwcie.ups.com/ups.app/xml'
            : 'https://onlinetools.ups.com:443/ups.app/xml';
    }

    /**
     * @param array $inputData
     *
     * @return mixed
     */
    public function getRates($inputData)
    {
        $url = $this->getApiURL() . '/Rate';

        $request = new Request\XMLRequest($url, $inputData);
        $request->setInputMapper(new Mapper\Rate\InputMapper($this->processor));
        $request->setOutputMapper(new Mapper\Rate\OutputMapper($this->processor));
        $request->sendRequest();

        $this->processor->addApiCommunicationMessage(
            array(
                'method' => __METHOD__,
                'URL' => $url,
                'request' => $request->getRawRequest(),
                'response' => $request->getRawResponse(),
            )
        );

        $this->processor->log(
            array(
                'method' => __METHOD__,
                'URL' => $url,
                'request' => $request->getRawRequest(),
                'response' => $request->getRawResponse(),
            )
        );

        return $request->getResponse();
    }

    /**
     * @param array $inputData
     *
     * @return mixed
     */
    public function getRatesCOD($inputData)
    {
        $url = $this->getApiURL() . '/Rate';

        $request = new Request\XMLRequest($url, $inputData);
        $request->setInputMapper(new Mapper\RateCOD\InputMapper($this->processor));
        $request->setOutputMapper(new Mapper\RateCOD\OutputMapper($this->processor));
        $request->sendRequest();

        $this->processor->addApiCommunicationMessage(
            array(
                'method' => __METHOD__,
                'URL' => $url,
                'request' => $request->getRawRequest(),
                'response' => $request->getRawResponse(),
            )
        );

        $this->processor->log(
            array(
                'method' => __METHOD__,
                'URL' => $url,
                'request' => \XLite\Core\XML::getInstance()->getFormattedXML($request->getRawRequest()),
                'response' => \XLite\Core\XML::getInstance()->getFormattedXML($request->getRawResponse()),
            )
        );

        return $request->getResponse();
    }
}
