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

namespace XLite\Module\Mostad\WashingtonTaxes\Logic\Order\Modifier;

use XLite\Module\CDev\SalesTax\Logic\Order\Modifier\Tax;
use XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier\VolumePricing;

class WashingtonTaxes extends Tax
{
    const STATE_NAME = 'Washington';
    const STATE_TAX_API_BASE_URL = 'http://dor.wa.gov/AddressRates.aspx?';
    // fallback rate in case the WA API fails to return a response.
    const STATE_TAX_FALLBACK = 0.099;

    public function determineTaxRate($address)
    {
        // http://dor.wa.gov/AddressRates.aspx?output=xml&addr=6500%20Linderson%20way&city=&zip=98501
        $url = self::STATE_TAX_API_BASE_URL
            . 'output=xml'
            . '&addr=' . urlencode($address->getStreet())
            . '&city=' . urlencode($address->getCity())
            . '&zip=' . urlencode($address->getZipcode());

        $request = new \XLite\Core\HTTP\Request($url);
        $response = $request->sendRequest();

        /*
         * <response loccode="3406" localrate="0.024" rate="0.089" code="0">
            <addressline houselow="6500" househigh="6598" evenodd="E" street="LINDERSON WAY SW" state="WA" zip="98501" plus4="6561" period="Q22016" code="3406" rta="N" ptba="Thurston PTBA" cez=""/>
            <rate name="TUMWATER" code="3406" staterate="0.065" localrate="0.024"/>
            </response>
         */

        if (!$response) {
            return self::STATE_TAX_FALLBACK;
        }

        $xmlResponse = simplexml_load_string($response->body);

        $attributes = $xmlResponse->attributes();
        $rate = (double)$attributes->rate;
        if (empty($rate)) {
            return self::STATE_TAX_FALLBACK;
        }

        return $rate;
    }

    public function calculate()
    {

        $address = $this->getOrderAddress();

        if (!$address || !$address->getState() || $address->getState()->getState() != self::STATE_NAME) {
            return array();
        }

        $results = parent::calculate();

        $rate = $this->determineTaxRate($address);

        $salesTax = $this->getOrder()->getDisplaySubtotal() * $rate;

        /** @var \XLite\Model\Order\Surcharge $surcharge */
        foreach ($this->getOrder()->getSurchargesByType(VolumePricing::MODIFIER_TYPE) as $surcharge) {
            $salesTax += $surcharge->getValue() * $rate;
        }

        $results[] = $this->addOrderSurcharge(self::MODIFIER_CODE, $salesTax);
        return $results;
    }
}
