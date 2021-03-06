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
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'designation' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Designation',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'name' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Name',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'address' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Address',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'address2' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Address 2',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'city' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'City',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'state' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\State',
            self::SCHEMA_LABEL    => 'State',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            'country' => 'US',
        ),
        'zip' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Zip Code',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'phoneCode' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
            \XLite\View\FormField\Input\Text::PARAM_WRAPPER_CLASS => 'phone-code',
        ),
        'phone' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Phone',
            self::SCHEMA_LABEL    => 'Phone',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
            \XLite\View\FormField\Input\Text::PARAM_WRAPPER_CLASS => 'phone-number',
        ),
        'faxCode' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
            \XLite\View\FormField\Input\Text::PARAM_WRAPPER_CLASS => 'phone-code',
        ),
        'fax' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Phone',
            self::SCHEMA_LABEL    => 'FAX',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
            \XLite\View\FormField\Input\Text::PARAM_WRAPPER_CLASS => 'phone-number',
        ),
        'email' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Email',
            self::SCHEMA_LABEL    => 'Email',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'website' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Website',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'addLogo' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like to add a logo?',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
        ),
        'onlineFirmName' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Firm Name',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'onlineEmail' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text\Email',
            self::SCHEMA_LABEL    => 'Email',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'onlineWebsite' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Website',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
        ),
        'onlineAddLogo' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like to add a logo?',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
        ),
        'onlineAddToSite' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'Would you like us to add links to your site that we created?',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_ATTRIBUTES => ['class' => 'disable-for-same'],
            self::SCHEMA_FIELD_ONLY => true,
        ),
        'confirm' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
            self::SCHEMA_LABEL    => 'I have reviewed my imprint information above and verified that it is correct.',
            self::SCHEMA_REQUIRED => true,
            self::SCHEMA_FIELD_ONLY => true,
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
        $model = \XLite\Core\Database::getRepo('XLite\Module\Mostad\ImprintingInformation\Model\Imprinting')
                                     ->findOneByOrder($this->getCart(false)->getUniqueIdentifier());

        if ($model) {
            $model->confirm = false;
            return $model;
        }

        $model = \XLite\Core\Database::getRepo('XLite\Module\Mostad\ImprintingInformation\Model\Imprinting')
                                     ->findLatestByProfileId($this->getProfileId());

        if ($model) {
            $model->confirm = false;
            $model->status = null;
            return $model;
        }

        return new \XLite\Module\Mostad\ImprintingInformation\Model\Imprinting;
    }


    /**
     * Return current profile ID
     *
     * @return integer
     */
    protected function getProfileId()
    {
        return \XLite\Core\Auth::getInstance()->isOperatingAsUserMode()
            ? \XLite\Core\Auth::getInstance()->getOperatingAs()
            : \XLite\Core\Session::getInstance()->profile_id;
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

    protected function setModelProperties(array $data)
    {
        if (is_string($data['state'])) {
            $data['state'] = \XLite\Core\Database::getRepo('XLite\Model\State')->find($data['state']);
        }
        parent::setModelProperties($data);
    }

    protected function getTemplate()
    {
        return 'modules/Mostad/ImprintingInformation/model/form/content.tpl';
    }

    public function displayField($section, $name)
    {
        $field = $this->getFormField($section, $name);

        if ($field->getValue() !== $this->getModelObjectValue($name)) {
            $field->setValue($this->getModelObjectValue($name));
        }

        return $field->display();
    }



}