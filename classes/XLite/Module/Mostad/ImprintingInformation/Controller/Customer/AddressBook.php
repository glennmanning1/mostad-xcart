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

namespace XLite\Module\Mostad\ImprintingInformation\Controller\Customer;


class AddressBook extends \XLite\Controller\Customer\AddressBook implements \XLite\Base\IDecorator
{

    protected function doActionSave()
    {
        $result = $this->getModelForm()->performAction('update');
        if ($result) {
            $cookie = \XLite\Core\Request::getInstance()->getCookieData();

            $this->setHardRedirect();

            if (!empty($cookie['headedToCheckout'])) {
                \XLite\Core\Request::getInstance()->unsetCookie('headedToCheckout');
                $this->setReturnURL($this->buildURL('checkout'));
                $this->doRedirect();
            }
        }

        return $result;
    }

}