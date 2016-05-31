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


class Address extends \XLite\View\FormField\Select\RadioButtonsList\ARadioButtonsList
{

    /**
     * Get default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $addresses = $this->getCart()->getProfile()->getAddresses();

        $formattedAddresses = [];
        foreach ($addresses as $address) {
            $formattedAddresses[$address->getAddressId()] = $address;
        }

        return $formattedAddresses;
    }

    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'address/style.css';

        return $list;
    }


    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/Mostad/ImprintingInformation/address/controller.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/Mostad/ImprintingInformation/address/body.tpl';
    }
}