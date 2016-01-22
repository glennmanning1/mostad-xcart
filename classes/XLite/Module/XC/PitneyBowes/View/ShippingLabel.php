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

namespace XLite\Module\XC\PitneyBowes\View;

/**
 * Create shipping label
 *
 */
class ShippingLabel extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'parcel';

        return $list;
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/PitneyBowes/asn/label/style.css';

        return $list;
    }

    protected function getBarcodeURL()
    {
        return $this->buildURL(
            'parcel',
            'draw_barcode',
            array(
                'id' => \XLite\Core\Request::getInstance()->id,
                'order_number' => \XLite\Core\Request::getInstance()->order_number,
            )
        );
    }

    protected function getRecipient()
    {
        $profile = $this->getOrder()->getProfile();

        return $profile && $profile->getName() ? $profile->getName() : '';
    }

    protected function getDestination()
    {
        $destination = '';
        $response = $this->getOrder()->getPbOrder() ? $this->getOrder()->getPbOrder()->getCreateOrderResponse() : null;
        if ($response && $response->shipToHub && $response->shipToHub->hubAddress) {
            $address = $response->shipToHub->hubAddress;
            $destination = $address->street1 . '<br>' . $address->city . ' ' . $address->provinceOrState . ' ' . $address->postalOrZipCode;
        }
        return $destination;
    }

    protected function getPhone()
    {
        $modifier = $this->getOrder()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING')->getModifier();
        $address = \XLite\Model\Shipping::getInstance()->getDestinationAddress($modifier);
        $addressObject = $this->getOrder()->getProfile()->getShippingAddress();

        $phone = $addressObject && $addressObject->getPhone() ? $addressObject->getPhone() : '';

        return $phone;
    }

    protected function getOrderNumber()
    {
        return $this->getOrder()->getPbOrder() ? $this->getOrder()->getPbOrder()->getOrmus() : '';
    }

    protected function getBarcodeText()
    {
        return $this->getParcel()->getNumber();
    }

    public function isVisible()
    {
        return parent::isVisible()
            && isset(\XLite\Core\Request::getInstance()->id)
            && isset(\XLite\Core\Request::getInstance()->order_number);
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/PitneyBowes/asn/label/template.tpl';
    }
}
