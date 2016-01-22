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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper;

abstract class AMapper implements IMapper
{
    /**
     * @var mixed
     */
    protected $inputData;

    /**
     * @var mixed
     */
    protected $outputData;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * @var IMapper
     */
    protected $nextMapper;

    /**
     * @var array
     */
    protected $additionalData;

    /**
     * @param mixed     $config      Config
     */
    function __construct($config)
    {
        $this->config = $config;
        $this->additionalData = array();
    }

    /**
     * Set input data
     * 
     * @param mixed     $inputData  Input data
     * @param string    $key        Additional data key     OPTIONAL
     * 
     * @return void
     */
    public function setInputData($inputData, $key = 'default')
    {
        if ('default' == $key) {
            $this->inputData = $inputData;
        } else {
            $this->additionalData[$key] = $inputData;
        }
    }

    /**
     * Get additional data by key
     * 
     * @param string    $key        Additional data key
     * 
     * @return mixed
     */
    protected function getAdditionalData($key)
    {
        return isset($this->additionalData[$key])
            ? $this->additionalData[$key]
            : null;
    }

    /**
     * Set next mapper if current will not succeed
     * 
     * @param IMapper $nextMapper Next mapper
     * 
     * @return void
     */
    public function setNextMapper(IMapper $nextMapper)
    {
        $this->nextMapper = $nextMapper;
    }

    /**
     * Is mapper able to map?
     * 
     * @return boolean
     */
    abstract protected function isApplicable();

    /**
     * Perform actual mapping
     * 
     * @return mixed
     */
    abstract protected function performMap();

    /**
     * Postprocess mapped data
     * 
     * @param mixed $mapped mapped data to postprocess
     * 
     * @return mixed
     */
    abstract protected function postProcessMapped($mapped);

    /**
     * @return mixed
     */
    public function getMapped()
    {
        $result = null;

        if ($this->isApplicable()) {
            $result = $this->postProcessMapped($this->performMap());
        } elseif ($this->nextMapper) {
            $this->nextMapper->setInputData($this->inputData);
            $result = $this->nextMapper->getMapped();
        } else {
            \XLite\Logger::logCustom("PitneyBowes", 'Internal error in mapper ' . get_class($this), false);
        }

        return $result;
    }
}