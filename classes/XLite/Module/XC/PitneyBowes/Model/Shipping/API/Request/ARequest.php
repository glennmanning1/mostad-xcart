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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\API\Request;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;

/**
 * Abstract api request
 */
class ARequest
{
    const POST  = 'post';
    const GET   = 'get';
    const PUT   = 'put';

    const CONTENT_TYPE   = 'text/plain';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $inputData;

    /**
     * @var string
     */
    protected $httpType = self::POST;

    /**
     * @var \XLite\Core\HTTP\Request
     */
    protected $request;

    /**
     * @var \PEAR2\HTTP\Request\Response
     */
    protected $response;

    /**
     * @var \XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper\IMapper Input mapper
     */
    protected $inputMapper;

    /**
     * @var \XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper\IMapper Output mapper
     */
    protected $outputMapper;

    /**
     * Construct
     */
    public function __construct($url, $inputData)
    {
        $this->url          = $url;
        $this->inputData    = $inputData;

        $this->request = new \XLite\Core\HTTP\Request($this->url);
        $this->request->verb = $this->httpType;

        $this->setContentType(static::CONTENT_TYPE);
    }

    /**
     * Prepare parameters for request
     * 
     * @return mixed
     */
    protected function prepareParameters()
    {
        $result = null;

        if ($this->inputMapper) {
            $this->inputMapper->setInputData($this->inputData);
            $result = $this->inputMapper->getMapped();
        }

        return $result ?: $this->inputData;
    }

    /**
     * Set input mapper
     * 
     * @param \XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper\IMapper $mapper Mapper
     * 
     * @return void
     */
    public function setInputMapper(API\Mapper\IMapper $mapper)
    {
        $this->inputMapper = $mapper;
    }

    /**
     * Set output mapper
     * 
     * @param \XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper\IMapper $mapper Mapper
     * 
     * @return void
     */
    public function setOutputMapper(API\Mapper\IMapper $mapper)
    {
        $this->outputMapper = $mapper;
    }

    /**
     * sendRequest
     */
    public function sendRequest()
    {
        $this->request->body = $this->prepareParameters();

        $this->response = $this->request->sendRequest();
    }

    public function setAuth($type, $value)
    {
        $this->request->setHeader(
            'Authorization',
            sprintf('%s %s', $type, $value));
    }

    public function setContentType($value)
    {
        $this->request->setHeader('Content-Type', $value);
    }

    /**
     * 
     */
    public function getResponse()
    {
        $result = null;

        if ($this->outputMapper) {
            $this->outputMapper->setInputData($this->response);
            $this->outputMapper->setInputData($this->inputData, 'requested');
            $result = $this->outputMapper->getMapped();
        } else {
            $result = $this->getRawResponse();
        }

        return $result;
    }

    /**
     * 
     */
    public function getRawRequest()
    {
        return $this->prepareParameters();
    }

    /**
     * 
     */
    public function getRawResponse()
    {
        return $this->response->body;
    }
}
