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

namespace XLite\Module\XC\PitneyBowes\View\Model;

/**
 * Credentials request view model
 *
 * @ListChild (list="pb-credentials", zone="admin")
 */
class Credentials extends \XLite\View\Model\AModel
{
    const SCHEMA_FIELD_COMPANY_NAME     = 'company';
    const SCHEMA_FIELD_MERCHANT_NAME    = 'name';
    const SCHEMA_FIELD_EMAIL            = 'email';
    const SCHEMA_FIELD_PHONE            = 'phone';
    const SCHEMA_FIELD_BUSINESS_ADDRESS = 'businessAddress';
    const SCHEMA_FIELD_SITE_URL         = 'siteUrl';

    /**
     * Default form values
     *
     * @var array
     */
    protected $defaultValues;

    /**
     * Schema default
     *
     * @var array
     */
    protected $schemaDefault = array(
        self::SCHEMA_FIELD_MERCHANT_NAME => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL     => 'Your name',
            self::SCHEMA_REQUIRED  => true,
        ),
        self::SCHEMA_FIELD_COMPANY_NAME => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL     => 'Company name',
            self::SCHEMA_REQUIRED  => true,
        ),
        self::SCHEMA_FIELD_EMAIL => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text\Email',
            self::SCHEMA_LABEL     => 'Email',
            self::SCHEMA_REQUIRED  => true,
        ),
        self::SCHEMA_FIELD_PHONE => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text\Phone',
            self::SCHEMA_LABEL     => 'Phone number',
            self::SCHEMA_REQUIRED  => false,
        ),
        self::SCHEMA_FIELD_BUSINESS_ADDRESS => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Textarea\Simple',
            self::SCHEMA_LABEL     => 'Business Address',
            self::SCHEMA_REQUIRED  => true,
            \XLite\View\FormField\Textarea\Simple::PARAM_ROWS    => 4,
            \XLite\View\FormField\Textarea\Simple::PARAM_ATTRIBUTES => array('style' => 'width: 250px;')
        ),
        self::SCHEMA_FIELD_SITE_URL => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL     => 'Site URL',
            self::SCHEMA_REQUIRED  => true,
        ),
    );

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\AEntity
     */
    protected function getDefaultModelObject()
    {
        return null;
    }

    /**
     * Retrieve property from the model object
     *
     * @param mixed $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        if (is_null($this->defaultValues)) {
            $this->defaultValues = $this->getDefaultModelObjectValues();
        }

        return isset($this->defaultValues[$name]) ? $this->defaultValues[$name] : null;
    }

    /**
     * Prepare company address as string
     * 
     * @return string
     */
    protected function prepareAddressFieldValue($config)
    {
        $state = $config->Company->location_custom_state;

        if (is_numeric($config->Company->location_state)) {
            $stateEntity = \XLite\Core\Database::getRepo('XLite\Model\State')->find(
                $config->Company->location_state
            );
            if ($stateEntity
                && $stateEntity->getCountry()->getCode() == $config->Company->location_country
            ) {
                $state = $stateEntity->getState();
            }
        }

        $country = '';

        if ($config->Company->location_country) {
            $countryEntity = \XLite\Core\Database::getRepo('XLite\Model\Country')->find(
                $config->Company->location_country
            );
            if ($countryEntity) {
                $country = $countryEntity->getCountry();
            }
        }

        $fields = array(
            $country,
            $state,
            $config->Company->location_city,
            $config->Company->location_address,
            $config->Company->location_zipcode
        );

        return implode(', ', $fields);
    }

    /**
     * Get config
     * 
     * @return \XLite\Core\Config
     */
    protected function getConfig()
    {
        \XLite\Core\Config::updateInstance();
        return \XLite\Core\Config::getInstance();
    }

    /**
     * Get default model object values
     *
     * @return array
     */
    protected function getDefaultModelObjectValues()
    {
        $config = $this->getConfig();

        return array(
            self::SCHEMA_FIELD_COMPANY_NAME     => $config->Company->company_name,
            self::SCHEMA_FIELD_MERCHANT_NAME    => \XLite\Core\Auth::getInstance()->getProfile()->getName(),
            self::SCHEMA_FIELD_EMAIL            => \XLite\Core\Auth::getInstance()->getProfile()->getLogin(),
            self::SCHEMA_FIELD_PHONE            => $config->Company->company_phone,
            self::SCHEMA_FIELD_BUSINESS_ADDRESS => $this->prepareAddressFieldValue($config),
            self::SCHEMA_FIELD_SITE_URL         => \XLite::getInstance()->getShopURL(),
        );
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\PitneyBowes\View\Form\Credentials';
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $result['submit'] = new \XLite\View\Button\ProgressState(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => 'Request credentials',
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action always-enabled',
                \XLite\View\Button\Regular::PARAM_JS_CODE  => 'this.form.submit()',
            )
        );

        $result['shipping_methods'] = new \XLite\View\Button\SimpleLink(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => static::t('Back to shipping methods'),
                \XLite\View\Button\AButton::PARAM_STYLE => 'action shipping-list-back-button',
                \XLite\View\Button\Link::PARAM_LOCATION => $this->buildURL('shipping_methods'),
            )
        );

        return $result;
    }

    /**
     * Perform some operations when creating fields list by schema
     *
     * @param string $name Node name
     * @param array  $data Field description
     *
     * @return array
     */
    protected function getFieldSchemaArgs($name, array $data)
    {
        $data = parent::getFieldSchemaArgs($name, $data);

        return $data;
    }

    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        parent::setModelProperties($data);
    }
}
