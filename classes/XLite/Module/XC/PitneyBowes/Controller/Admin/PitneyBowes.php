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

namespace XLite\Module\XC\PitneyBowes\Controller\Admin;

/**
 * PitneyBowes settings page controller
 */
class PitneyBowes extends \XLite\Controller\Admin\ShippingSettings
{
    const PB_CONF_FIRST = 'XLite\Module\XC\PitneyBowes\View\FirstConfiguration';
    const PB_CONF_REQUEST = 'XLite\Module\XC\PitneyBowes\View\CredentialsRequest';

    /**
     * getOptionsCategory
     *
     * @return string
     */
    protected function getOptionsCategory()
    {
        return 'XC\PitneyBowes';
    }

    protected function getPopupNames()
    {
        return array(
            static::PB_CONF_FIRST => static::t('First time configuration'),
            static::PB_CONF_REQUEST => static::t('Complete this form to request credentials'),
        );
    }

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = parent::getTitle();
        $widget = ltrim(\XLite\Core\Request::getInstance()->widget, '\\');
        if ($widget && array_key_exists($widget, $this->getPopupNames())) {
            $names = $this->getPopupNames();
            $title = $names[$widget];
        }
        return $title;
    }

    /**
     * Get model form class
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\PitneyBowes\View\Model\Settings';
    }

    /**
     * Get shipping processor
     *
     * @return \XLite\Model\Shipping\Processor\AProcessor
     */
    protected function getProcessor()
    {
        return new \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes();
    }

    /**
     * Disable credentials popup
     *
     * @return void
     */
    protected function doActionDisablePopup()
    {
        \XLite\Core\Database::getRepo('\XLite\Model\Config')->createOption(
            array(
                'category' => $this->getOptionsCategory(),
                'name'     => 'credentials_requested',
                'value'    => true
            )
        );
        $this->setPureAction(true);

        $this->setReturnURL(\XLite\Core\Converter::buildURL($this->getTarget()));
        $this->setHardRedirect();
    }

    /**
     * Send request to PB API to register new merchant
     *
     * @return void
     */
    protected function doActionRequestCredentials()
    {
        $data = array(
            'name' => array(
                'humanName' => 'Name',
                'value'     => \XLite\Core\Request::getInstance()->name,
            ),
            'company' => array(
                'humanName' => 'Company name',
                'value'     => \XLite\Core\Request::getInstance()->company,
            ),
            'email' => array(
                'humanName' => 'Email',
                'value'     => \XLite\Core\Request::getInstance()->email,
            ),
            'phone' => array(
                'humanName' => 'Phone number',
                'value'     => \XLite\Core\Request::getInstance()->phone,
            ),
            'businessAddress' => array(
                'humanName' => 'Business Address',
                'value'     => \XLite\Core\Request::getInstance()->businessAddress,
            ),
            'siteUrl' => array(
                'humanName' => 'Site URL',
                'value'     => \XLite\Core\Request::getInstance()->siteUrl,
            ),
            'xcartVersion' => array(
                'humanName' => 'Current X-Cart Version',
                'value'     => \XLite::getInstance()->getVersion(),
            ),
        );

        $errors = array();
        $errors['customer']     = \XLite\Core\Mailer::sendCredentialsRequestNotificationToCustomer($data);
        $errors['pitneybowes']  = \XLite\Core\Mailer::sendCredentialsRequestToPB($data);

        $requestSucceed = false;

        if (false === $errors['customer'] || false === $errors['pitneybowes']) {
            \XLite\Core\TopMessage::getInstance()->addError(
                static::t('Something went wrong.')
            );
        } else {
            \XLite\Core\TopMessage::getInstance()->addInfo(
                static::t('Your request has been successfully submitted for PB International Shipping. The PB team will be reaching out to you shortly with your credentials. Please check you emails. Thank you and speak soon.')
            );
            $requestSucceed = true;
        }

        \XLite\Core\Database::getRepo('\XLite\Model\Config')->createOption(
            array(
                'category' => $this->getOptionsCategory(),
                'name'     => 'credentials_requested',
                'value'    => $requestSucceed
            )
        );

        $this->setReturnURL(\XLite\Core\Converter::buildURL($this->getTarget()));
    }

    /**
     * Get schema of an array for test rates routine
     *
     * @return array
     */
    protected function getTestRatesSchema()
    {
        $schema = parent::getTestRatesSchema();

        unset($schema['subtotal']);
        unset($schema['weight']);
        unset($schema['srcAddress']);
        unset($schema['dstAddress']['type']);

        $schema['commodity'] = \XLite\Module\XC\PitneyBowes\View\Model\TestRates::SCHEMA_FIELD_COMMODITY;

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
        $package = parent::getTestRatesData($schema, $errors);

        $data = array(
            'packages' => array($package),
        );

        return $data;
    }

    /**
     * Checks if first time configuration window should be displayed
     *
     * @return boolean
     */
    public function isCredentialsRequested()
    {
        \XLite\Core\Config::updateInstance();
        return (boolean) \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration()->credentials_requested;
    }
}
