{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Egoods email body (to customer)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<p>
    <h2>{t(#Credentials request#)}</h2>
</p>
<p>
  <ul>
    <li FOREACH="data,dataField">
        <span>{dataField.humanName}</span> - <span>{dataField.value}</span>
    </li>
  </ul>
</p>
<style>
    h1.greeting{
        display: none !important;
    }
    #emailFooter{
        display: none !important;
    }
</style>