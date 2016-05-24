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

namespace XLite\Module\Mostad\ImprintingInformation\View\FormField;


class Address extends \XLite\View\FormField\Select\Model\AModel
{

    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/Mostad/ImprintingInformation/address/controller.js';

        return $list;
    }

    protected function getDataType()
    {
        return 'address';
    }

    protected function getDefaultEmptyPhrase()
    {
        return 'No address selected';
    }

    protected function getDefaultTemplate()
    {
        return $this->buildURL('model_address_selector');
    }


    /**
     * Defines the text value of the model
     *
     * @return string
     */
    protected function getTextValue()
    {
        $address = \XLite\Core\Database::getRepo('XLite\Model\Address')->find('1');

        return $address ? 'wat' : 'nope';
    }

    protected function getTextName()
    {
        return $this->getParam(static::PARAM_NAME) . '_text';
    }
}