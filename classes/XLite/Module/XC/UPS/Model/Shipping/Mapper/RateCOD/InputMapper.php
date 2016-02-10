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

namespace XLite\Module\XC\UPS\Model\Shipping\Mapper\RateCOD;

use XLite\Module\XC\UPS\Model\Shipping\Mapper\Rate;

class InputMapper extends Rate\InputMapper
{
    /**
     * @return array
     */
    protected function getShipmentServiceOptions()
    {
        $result = parent::getShipmentServiceOptions();

        $srcCountry = $this->inputData['srcAddress']['country'];
        $dstCountry = $this->inputData['dstAddress']['country'];
        if ($this->isShipmentCODAllowed($srcCountry, $dstCountry)) {
            $shipmentTotal = round((float) $this->inputData['total'], 2);

            $result['COD'] =<<<XML
<COD>
    <CODFundsCode>9</CODFundsCode>
    <CODAmount>
        <CurrencyCode>{$this->destinationCurrency}</CurrencyCode>
        <MonetaryValue>{$shipmentTotal}</MonetaryValue>
    </CODAmount>
</COD>
XML;
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getPackageServiceOptions($package)
    {
        $result = parent::getPackageServiceOptions($package);
        $packageSubtotal = round((float) $package['subtotal'], 2);

        $srcCountry = $this->inputData['srcAddress']['country'];
        $dstCountry = $this->inputData['dstAddress']['country'];
        if ($this->isPackageCODAllowed($srcCountry, $dstCountry)) {
            unset($result['DeliveryConfirmation']);
            $result['COD'] =<<<XML
<COD>
    <CODFundsCode>0</CODFundsCode>
    <CODAmount>
        <CurrencyCode>{$this->destinationCurrency}</CurrencyCode>
        <MonetaryValue>{$packageSubtotal}</MonetaryValue>
    </CODAmount>
</COD>
XML;
        }

        return $result;
    }
}
