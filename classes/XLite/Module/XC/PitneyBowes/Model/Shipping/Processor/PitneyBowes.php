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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\Processor;

use \XLite\Module\XC\PitneyBowes\Model\Shipping\API;
use \XLite\Module\XC\PitneyBowes\Model\Shipping\Mapper;

/**
 * Shipping processor model
 * API documentation: https://wiki.ecommerce.pb.com/display/TECH4/Pitney+Bowes+Ecommerce+-+Technical+Wiki
 */
class PitneyBowes extends \XLite\Model\Shipping\Processor\AProcessor
{
    const PROCESSOR_ID = 'PitneyBowes';

    /**
     * Create order API call TTL
     */
    const CREATE_ORDER_TTL = 3600;

    /**
     * @var \XLite\Core\ConfigCell
     */
    protected static $config;

    /**
     * @var \XLite\Module\XC\PitneyBowes\Model\Shipping\PitneyBowesApiFacade
     */
    protected static $api;

    /**
     * Construct
     */
    public function __construct()
    {
        static::updateConfiguration($this->getConfiguration());
    }

    public static function updateConfiguration($config)
    {
        static::$config = $config;
        static::$api = new \XLite\Module\XC\PitneyBowes\Model\Shipping\PitneyBowesApiFacade(static::$config);
    }

    /**
     * Retrieve config
     * 
     * @param boolean $force Forced default configuration
     * 
     * @return \XLite\Core\ConfigCell
     */
    public static function getProcessorConfiguration($force = false)
    {
        if (!static::$config || $force) {
            $processorInstance = new static();
            static::updateConfiguration($processorInstance->getConfiguration());
        }

        return static::$config;
    }

    /**
     * Debug logging
     * 
     * @param mixed $message Message
     * @param mixed $message Message
     * 
     * @return void
     */
    public static function logDebug($message, $backtrace = false)
    {
        if (static::getProcessorConfiguration()->debug_enabled) {
            \XLite\Logger::logCustom(
                'PitneyBowesDebug',
                $message,
                $backtrace
            );
        }
    }

    /**
     * Returns processor Id
     *
     * @return string
     */
    public function getProcessorId()
    {
        return self::PROCESSOR_ID;
    }

    /**
     * Returns url for sign up
     *
     * @return string
     */
    public function getSettingsURL()
    {
        return \XLite\Module\XC\PitneyBowes\Main::getSettingsForm();
    }

    /**
     * getProcessorName
     *
     * @return string
     */
    public function getProcessorName()
    {
        return 'Pitney Bowes International';
    }

    /**
     * Get shipping method admin zone icon URL
     *
     * @param \XLite\Model\Shipping\Method $method Shipping method
     *
     * @return string
     */
    public function getAdminIconURL(\XLite\Model\Shipping\Method $method)
    {
        return true;
    }

    /**
     * Disable the possibility to edit the names of shipping methods in the interface of administrator
     *
     * @return boolean
     */
    public function isMethodNamesAdjustable()
    {
        return true;
    }

    /**
     * Get list of address fields required by shipping processor
     *
     * @return array
     */
    public function getRequiredAddressFields()
    {
        return array(
            'country_code',
        );
    }

    /**
     * 
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * 
     * @return string
     */
    protected function getNonGuaranteedCacheKey($inputData)
    {
        return $this->getProcessorId() . static::$api->getQuoteCacheKey($inputData);
    }

    /**
     * 
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * 
     * @return string
     */
    protected function getGuaranteedCacheKey($inputData)
    {
        return $this->getProcessorId() . static::$api->createOrderCacheKey($inputData);
    }

    /**
     * Check if getRates should return guaranteed rates
     * 
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * 
     * @return boolean
     */
    protected function isGuaranteedRatesNeeded($inputData)
    {
        return !is_array($inputData)
            && 'checkout' == \XLite::getController()->getTarget()
            && $inputData->getOrder()->isPitneyBowesSelected();
    }

    /**
     * Returns shipping rates
     *
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * @param boolean                                    $ignoreCache Flag: if true then do not get rates from cache OPTIONAL
     *
     * @return array
     */
    public function getRates($inputData, $ignoreCache = false)
    {
        $this->errorMsg = null;
        $rates = array();

        if ($this->isConfigured()) {
            if (
                \XLite::isAdminZone()
                && 'order' === \XLite::getController()->getTarget()
                && 'recalculate'    === \XLite::getController()->getAction()
            ) {
                // Realisation of createOrder and confirmOrder in AOM, but today...
                // So called 'The knight's move'
                $rates = array();
            } elseif ($this->isGuaranteedRatesNeeded($inputData)) {

                $key = \XLite\Core\Session::getInstance()->getID();
                while (\XLite\Core\Lock\FileLock::getInstance()->isRunning($key)) {
                    usleep(100);
                }
                \XLite\Core\Lock\FileLock::getInstance()->setRunning($key);

                $rates = $this->getGuaranteedRates($inputData, $ignoreCache);

                \XLite\Core\Lock\FileLock::getInstance()->release($key);
            } else {
                $rates = $this->getNonGuaranteedRates($inputData, $ignoreCache);
            }

        } elseif (\XLite\Module\XC\PitneyBowes\Main::isStrictMode()) {
            $this->errorMsg = 'PitneyBowes module is not configured';
        }

        return $rates;
    }

    /**
     * Internal unconditional getRates() part
     * 
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * @param boolean                                    $ignoreCache Flag: if true then do not get rates from cache OPTIONAL
     *
     * @return array
     */
    protected function getNonGuaranteedRates($inputData, $ignoreCache = false)
    {
        $rates = array();

        $cachedRate = null;

        if (!$ignoreCache) {
            $cachedRate = $this->getDataFromCache($this->getNonGuaranteedCacheKey($inputData));
        }

        if (null !== $cachedRate) {
            $rates = $cachedRate;

        } elseif (\XLite\Model\Shipping::isIgnoreLongCalculations()) {
            $rates = array();

        } else {
            $rates = $this->getNonGuaranteedRatesFromServer($inputData);
            if ($rates) {
                // Force translations lazy loadin
                foreach ($rates as $rate) {
                    $rate->getMethod()->getName();
                }
            }
            $this->saveDataInCache($this->getNonGuaranteedCacheKey($inputData), $rates);
        }

        return $rates;
    }

    /**
     * Internal unconditional getRates() part
     * 
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * 
     * @return array
     */
    protected function getNonGuaranteedRatesFromServer($inputData)
    {
        $rates = array();
        if ($inputData && !empty($inputData)) {
            $rates = static::$api->getQuote($inputData);

        } elseif (\XLite\Module\XC\PitneyBowes\Main::isStrictMode()) {
            $this->errorMsg = 'Wrong input data';
        }

        return $rates;
    }

    /**
     * Internal unconditional getRates() part
     * 
     * @param \XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * @param boolean                              $ignoreCache Flag: if true then do not get rates from cache OPTIONAL
     *
     * @return array
     */
    protected function getGuaranteedRates($inputData, $ignoreCache = false)
    {
        $rates = array();

        $cachedRate = null;

        if (!$ignoreCache) {
            $cachedRate = $this->getDataFromCache($this->getGuaranteedCacheKey($inputData));
        }

        if (null !== $cachedRate) {
            $rates = $cachedRate;

        } elseif (\XLite\Model\Shipping::isIgnoreLongCalculations()) {
            $rates = array();

        } else {
            $rates = $this->getGuaranteedRatesFromServer($inputData);
            if ($rates) {
                // Force translations lazy loading
                foreach ($rates as $rate) {
                    $rate->getMethod()->getName();
                }
                $this->saveDataInCache($this->getGuaranteedCacheKey($inputData), $rates, static::CREATE_ORDER_TTL);
            }
        }

        return $rates;
    }

    /**
     * Internal unconditional getRates() part
     * 
     * @param \XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data for request
     * 
     * @return array
     */
    protected function getGuaranteedRatesFromServer($inputData)
    {
        $rates = array();

        if ($inputData && !empty($inputData)) {
            $result = static::$api->createOrder($inputData);
            $rates = $result['rates'];
            if ($rates) {
                $inputData->getOrder()->updatePBOrder($result['orders']);
            }

        } elseif (\XLite\Module\XC\PitneyBowes\Main::isStrictMode()) {
            $this->errorMsg = 'Wrong input data';
        }

        return $rates;
    }

    // {{{ Static methods for calculations

    /**
     * @param integer $itemsCount Count items in order
     * 
     * @return decimal
     */
    public static function getShippingFeeMarkup($itemsCount)
    {
        $total = floatval(static::getProcessorConfiguration()->shipping_fee_markup);

        if (\XLite\Module\XC\PitneyBowes\View\FormField\Select\MarkupBasis::ITEM_BASIS == static::getProcessorConfiguration()->shipping_fee_markup_basis) {
            $total *= $itemsCount;
        }

        return $total;
    }

    /**
     * @param integer $itemsCount Count items in order
     * 
     * @return decimal
     */
    public static function getHandlingFeeMarkup($itemsCount)
    {
        $total = floatval(static::getProcessorConfiguration()->handling_fee_markup);

        if (\XLite\Module\XC\PitneyBowes\View\FormField\Select\MarkupBasis::ITEM_BASIS == static::getProcessorConfiguration()->handling_fee_markup_basis) {
            $total *= $itemsCount;
        }

        return $total;
    }

    /**
     * Get shipping method for rate
     * 
     * @param string $shippingMethodCode
     * 
     * @return \XLite\Model\Shipping\Method
     */
    public static function getMethod($methodCode)
    {
        $method = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method')->findOneBy(
            array(
                'processor' => \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::PROCESSOR_ID,
                'code'      => $methodCode,
            )
        );

        return $method;
    }

    /**
     * @param mixed $unserializedArray Unserialized value to fix
     * 
     * @return array
     */
    protected static function correctSerializedArray($unserializedArray)
    {
        return is_array($unserializedArray)
            ? $unserializedArray
            : array();
    }

    /**
     * Check if value is in settings array
     * 
     * @param mixed $needle Value to search
     * @param mixed $haystack Setting value
     * 
     * @return boolean
     */
    protected static function inSettingsArray($needle, $haystack)
    {
        return in_array($needle, static::correctSerializedArray($haystack));
    }

    /**
     * Get transportation part of rate
     * 
     * @param float     $subtotal
     * @param string    $countryCode
     * @param mixed     $orderJsonObject
     * 
     * @return float
     */
    public static function getTransportationPart($subtotal, $countryCode, $orderJsonObject)
    {
        $value = $orderJsonObject->totalTransportation->total->value;

        $threshold = static::getProcessorConfiguration()->free_transportation_threshold;

        $thresholdTrigger = static::getProcessorConfiguration()->free_transportation
            && '' !== $threshold
            && $subtotal > floatval($threshold);

        $countryTrigger = static::inSettingsArray($countryCode, static::getProcessorConfiguration()->free_transportation_countries);

        if ($thresholdTrigger && $countryTrigger) {
            $value = 0;
        }

        return $value;
    }

    /**
     * Get transportation part of rate
     * 
     * @param float     $subtotal
     * @param string    $countryCode
     * @param mixed     $orderJsonObject
     * 
     * @return float
     */
    public static function getImportationPart($subtotal, $countryCode, $orderJsonObject)
    {
        $value = $orderJsonObject->totalImportation->total->value;

        $threshold = static::getProcessorConfiguration()->free_importation_threshold;

        $thresholdTrigger = static::getProcessorConfiguration()->free_importation
            && '' !== $threshold
            && $subtotal > floatval($threshold);

        $countryTrigger = static::inSettingsArray($countryCode, static::getProcessorConfiguration()->free_importation_countries);

        if ($thresholdTrigger && $countryTrigger) {
            $value = 0;
        }

        return $value;
    }

    /**
     * Get transportation part of rate
     * 
     * @param float     $subtotal
     * @param string    $countryCode
     * @param mixed     $orderJsonObject
     * 
     * @return float
     */
    public static function getFullTransportationCost($subtotal, $countryCode, $orderJsonObject)
    {
        return static::getTransportationPart($subtotal, $countryCode, $orderJsonObject)
             + static::getImportationPart($subtotal, $countryCode, $orderJsonObject);
    }

    /**
     * Check if country applicable
     * 
     * @param string    $countryCode
     * 
     * @return boolean
     */
    public static function isCountryApplicable($countryCode)
    {
        return static::inSettingsArray($countryCode, static::getProcessorConfiguration()->applicable_countries);
    }

    // }}}

    /**
     * Defines whether the form must be used for tracking information.
     * The 'getTrackingInformationURL' result will be used as tracking link instead
     *
     * @param string $trackingNumber Tracking number value
     *
     * @return boolean
     */
    public function isTrackingInformationForm($trackingNumber)
    {
        return false;
    }

    /**
     * This method must return the URL to the detailed tracking information about the package.
     * Tracking number is provided.
     *
     * @param string $trackingNumber Tracking number
     *
     * @return string
     */
    public function getTrackingInformationURL($trackingNumber)
    {
        return 'https://parceltracking.pb.com/app/#/dashboard/'.$trackingNumber;
    }

    /**
     * Check test mode
     *
     * @return boolean
     */
    public function isTestMode()
    {
        $config = static::getProcessorConfiguration();

        return (bool) $config->test_mode;
    }

    /**
     * Get array of required config options
     */
    protected function getRequiredConfigOptions()
    {
        return array(
            'api_username',
            'api_password',
            'sftp_username',
            'sftp_password',
            'sftp_catalog_directory',
            'merchant_code',
            'sender_id',
        );
    }

    protected function arrayAny($array, $condition)
    {
        $result = false;

        if (is_callable($condition)) {
            foreach ($array as $key => $value) {
                if ($condition($key, $value)) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Returns true if PitneyBowes module is configured
     *
     * @return boolean
     */
    public function isConfigured()
    {
        $config = static::getProcessorConfiguration();

        return !$this->arrayAny(
            $this->getRequiredConfigOptions(),
            function($key, $option) use ($config){
                return !$config->{$option};
            }
        );
    }
}
