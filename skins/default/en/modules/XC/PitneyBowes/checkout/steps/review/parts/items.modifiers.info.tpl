{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : order review step : items : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 *}

<ul class='pitney-bowes-surcharge-info'>
    <li>
        <span class="info-part-name">{t(#Transportation fee#)}</span> - <span class="info-part-value">{getTransportationPart()}</span>
    </li>
    <li>
        <span class="info-part-name">{t(#Importation fee#)}</span> - <span class="info-part-value">{getImportationPart()}</span>
    </li>
</ul>
