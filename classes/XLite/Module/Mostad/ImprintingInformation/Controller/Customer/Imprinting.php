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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\Mostad\ImprintingInformation\Controller\Customer;

/**
 * Imprinting controller
 */
class Imprinting extends \XLite\Controller\Customer\ACustomer
{

    protected $params = array('target', 'order_id');

    public function getPageTitle()
    {
        return 'Order Imprint Information';
    }

    protected function getModelFormClass()
    {
        return 'XLite\Module\Mostad\ImprintingInformation\View\Model\Imprinting';
    }

    protected function doActionUpdate()
    {
        // Set Order ID on info to current cart
        $this->getModelForm()->getModelObject()->setOrder($this->getCart(false));

        $result = $this->getModelForm()->performAction('modify');

        if ($result) {
            $this->setHardRedirect();
            $this->setReturnURL($this->buildURL('checkout'));
            $this->doRedirect();
        }
    }

    public function getProfileId()
    {
        return $this->getCart(false)->getProfile()->getId();
    }

    /**
     * Get current aAddress id
     *
     * @return integer|void
     */
    public function getCurrentAddressId()
    {
        $address = null;

        if ($this->getCart()->getProfile()) {
            $address = \XLite\Model\Address::SHIPPING == \XLite\Core\Request::getInstance()->atype
                ? $this->getCart()->getProfile()->getShippingAddress()
                : $this->getCart()->getProfile()->getBillingAddress();
        }

        return $address ? $address->getAddressId() : null;
    }

    protected function getOrder()
    {
        return null;
    }
}