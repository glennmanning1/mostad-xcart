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

namespace XLite\Module\XC\AuctionInc\Controller\Admin;

/**
 * AuctionInc shipping module settings controller
 */
class AuctionInc extends \XLite\Controller\Admin\ShippingSettings
{
    /**
     * Check if SS available
     *
     * @return boolean
     */
    public function isSSAvailable()
    {
        return \XLite\Module\XC\AuctionInc\Main::isSSAvailable();
    }

    /**
     * Check if XS available
     *
     * @return boolean
     */
    public function isXSAvailable()
    {
        return !$this->isSSAvailable()
            && \XLite\Module\XC\AuctionInc\Main::isXSTrialPeriodValid();
    }

    /**
     * Check if XS expired
     *
     * @return boolean
     */
    public function isXSExpired()
    {
        return !$this->isSSAvailable() && !\XLite\Module\XC\AuctionInc\Main::isXSTrialPeriodValid();
    }

    /**
     * Return XS days
     *
     * @return boolean
     */
    public function getXSDays()
    {
        $result = 0;

        if (\XLite\Module\XC\AuctionInc\Main::isXSTrialPeriodValid()) {
            $firstUsageDate = \XLite\Core\Config::getInstance()->XC->AuctionInc->firstUsageDate;

            $result = \XLite\Module\XC\AuctionInc\Main::TRIAL_PERIOD_DURATION - (LC_START_TIME - $firstUsageDate);

            $result = round($result / (60 * 60 * 24));
        }

        return $result;
    }

    /**
     * Get shipping processor
     *
     * @return \XLite\Model\Shipping\Processor\AProcessor
     */
    protected function getProcessor()
    {
        return new \XLite\Module\XC\AuctionInc\Model\Shipping\Processor\AuctionInc();
    }

    /**
     * Returns options category
     *
     * @return string
     */
    protected function getOptionsCategory()
    {
        return 'XC\AuctionInc';
    }

    /**
     * Class name for the \XLite\View\Model\ form (optional)
     *
     * @return string|void
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\AuctionInc\View\Model\Settings';
    }

    /**
     * Get schema of an array for test rates routine
     *
     * @return array
     */
    protected function getTestRatesSchema()
    {
        $schema = parent::getTestRatesSchema();
        unset($schema['srcAddress']['city'], $schema['dstAddress']['city'], $schema['cod_enabled']);

        $schema['dimensions'] = 'dimensions';

        if (\XLite\Module\XC\AuctionInc\Main::isSSAvailable()) {
            unset($schema['srcAddress']);
        }

        return $schema;
    }

    /**
     * Get input data to calculate test rates
     *
     * @param array $schema  Input data schema
     * @param array &$errors Array of fields which are not set
     *
     * @return array
     */
    protected function getTestRatesData(array $schema, &$errors)
    {
        $data = parent::getTestRatesData($schema, $errors);
        list($data['length'], $data['width'], $data['height']) = $data['dimensions'];
        unset($data['dimensions']);

        return array(
            'package' => $data
        );
    }
}
