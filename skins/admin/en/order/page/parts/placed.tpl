{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : placed box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.operations", weight="30")
 *}

<div class="title">
  <div class="placed-date">{t(#Placed on DATE#,_ARRAY_(#date#^getOrderDate())):h}</div>
  <div class="placed-customer">
  {if:hasProfilePage()}
    {t(#Placed by _NAME_ EMAIL#,_ARRAY_(#name#^getProfileName(),#url#^getProfileURL(),#email#^getProfileEmail())):h}
  {else:}
    {t(#Placed by NAME EMAIL#,_ARRAY_(#name#^getProfileName(),#email#^getProfileEmail())):h}
  {end:}
  <span IF="getMembership()" class="membership">({membership.getName()})</span>
  </div>
</div>
