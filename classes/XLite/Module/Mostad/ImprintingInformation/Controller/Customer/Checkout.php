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


use XLite\Module\Mostad\ImprintingInformation\Model\Imprinting;

class Checkout extends \XLite\Controller\Customer\Checkout implements \XLite\Base\IDecorator
{

    /**
     * Go to cart view if cart is empty
     *
     * @return void
     */
    public function handleRequest()
    {
        if ($this->target == 'checkout' &&
                $this->cartHasItemsNeedingImprinting() &&
                !$this->orderHasConfirmedImprinting()
        ) {
            $this->setHardRedirect();
            $this->setReturnURL($this->buildURL('imprinting'));
            $this->doRedirect();
        }

        parent::handleRequest();
    }

    public function cartHasItemsNeedingImprinting()
    {

        /** @var OrderItem $item */
        foreach ($this->getCart()->getItems() as $item) {

            if ($item->needsImprinting()) {
                return true;
            }
        }
        return false;
    }

    protected function orderHasConfirmedImprinting()
    {
        return ($this->getImprintingInfo() && $this->getImprintingInfo()->getConfirm());
    }

    public function getImprintingInfo()
    {
        return $this->getCart(false)->getImprinting() ?: new Imprinting();
    }

    public function getImprintingFirmName()
    {
        return $this->getImprintingInfo()->getFirmName();
    }

    public function getImprintingWebsite()
    {
        return $this->getImprintingInfo()->getWebsite();
    }

    public function getImprintingEmail()
    {
        return $this->getImprintingInfo()->getEmail();
    }

}