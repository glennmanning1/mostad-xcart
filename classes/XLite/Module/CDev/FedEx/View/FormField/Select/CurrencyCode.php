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

namespace XLite\Module\CDev\FedEx\View\FormField\Select;

/**
 * Currency code selector for settings page
 */
class CurrencyCode extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options for selector
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'USD' => 'U.S. Dollars (USD)',
            'CAD' => 'Canadian Dollars (CAD)',
            'EUR' => 'European Currency Unit (EUR)',
            'JYE' => 'Japanese Yen (JYE)',
            'UKL' => 'British Pounds (UKL)',
            'NOK' => 'Norwegian Kronen (NOK)',
            'AUD' => 'Australian Dollars (AUD)',
            'HKD' => 'Hong Kong Dollars (HKD)',
            'NTD' => 'New Taiwan Dollars (NTD)',
            'SID' => 'Singapore Dollars (SID)',
            'ANG' => 'Antilles Guilder (ANG)',
            'RDD' => 'Dominican Peso (RDD)',
            'ARN' => 'Argentina Peso (ARN)',
            'ECD' => 'E. Caribbean Dollars (ECD)',
            'PKR' => 'Pakistan Rupee (PKR)',
            'AWG' => 'Aruban Florins (AWG)',
            'EGP' => 'Egyptian Pound (EGP)',
            'PHP' => 'Philippine Pesos (PHP)',
            'SAR' => 'Saudi Arabian Riyals (SAR)',
            'BHD' => 'Bahraini Dinars (BHD)',
            'BBD' => 'Barbados Dollars (BBD)',
            'INR' => 'Indian Rupees (INR)',
            'WON' => 'South Korea Won (WON)',
            'BMD' => 'Bermuda Dollars (BMD)',
            'JAD' => 'Jamaican Dollars (JAD)',
            'SEK' => 'Swedish Krona (SEK)',
            'BRL' => 'Brazil Real (BRL)',
            'SFR' => 'Swiss Francs (SFR)',
            'KUD' => 'Kuwaiti Dinars (KUD)',
            'THB' => 'Thailand Baht (THB)',
            'BND' => 'Brunei Dollar (BND)',
            'MOP' => 'Macau Patacas (MOP)',
            'TTD' => 'Trinidad &amp; Tobago Dollars (TTD)',
            'MYR' => 'Malaysian Ringgits (MYR)',
            'TRY' => 'Turkish Lira (TRY)',
            'CHP' => 'Chilean Pesos (CHP)',
            'UAE' => 'Mexican Pesos NMP (UAE)',
            'DHS' => 'Dirhams (DHS)',
            'CNY' => 'Chinese Renminbi (CNY)',
            'DKK' => 'Denmark Krone (DKK)',
            'NZD' => 'New Zealand Dollars (NZD)',
            'VEF' => 'Venezuela Bolivar (VEF)',
        );
    }
}
