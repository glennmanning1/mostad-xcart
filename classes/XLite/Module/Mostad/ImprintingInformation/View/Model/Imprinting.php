<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\Mostad\ImprintingInformation\View\Model;


class Imprinting extends \XLite\View\Model\AModel
{
    protected $schemaDefault = array(
        'status' => array(
            self::SCHEMA_CLASS    => 'XLite\Module\Mostad\ImprintingInformation\View\FormField\ImprintingStatus',
            self::SCHEMA_LABEL    => '',
            self::SCHEMA_REQUIRED => true,
        ),
        'firmName' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Firm Name',
            self::SCHEMA_REQUIRED => false,
        ),
//        'address' => array(
//            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\SKU',
//            self::SCHEMA_LABEL    => 'Address',
//            self::SCHEMA_REQUIRED => false,
//        ),
        'email' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Email',
            self::SCHEMA_LABEL    => 'Email',
            self::SCHEMA_REQUIRED => false,
        ),
        'website' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Url',
            self::SCHEMA_LABEL    => 'Website',
            self::SCHEMA_REQUIRED => false,
        ),
        'addLogo' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like to add a logo?',
            self::SCHEMA_REQUIRED => false,
        ),
        'onlineFirmName' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Firm Name',
            self::SCHEMA_REQUIRED => false,
        ),
        'onlineEmail' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Email',
            self::SCHEMA_LABEL    => 'Email',
            self::SCHEMA_REQUIRED => false,
        ),
        'onlineWebsite' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Url',
            self::SCHEMA_LABEL    => 'Website',
            self::SCHEMA_REQUIRED => false,
        ),
        'onlineAddLogo' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like to add a logo?',
            self::SCHEMA_REQUIRED => false,
        ),
        'onlineAddToSite' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like us to add links to your site that we created?',
            self::SCHEMA_REQUIRED => false,
        ),
        'confirm' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'I have reviewed my imprint information above and verified that it is correct.',
            self::SCHEMA_REQUIRED => true,
        ),
    );

    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->imprinting_id;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\AEntity
     */
    protected function getDefaultModelObject()
    {
        $model = $this->getModelId()
            ? \XLite\Core\Database::getRepo('XLite\Module\Mostad\ImprintingInformation\Model\Imprinting')->find($this->getModelId())
            : null;

        return $model ?: new \XLite\Module\Mostad\ImprintingInformation\Model\Imprinting;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\Module\Mostad\ImprintingInformation\View\Form\Model\Imprinting';
    }

    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => 'Save Imprinting Info',
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE => 'action',
            )
        );

        return $result;
    }
}