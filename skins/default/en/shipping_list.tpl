{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping rates list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="shipping-selector-box">
  {if:isDisplaySelector()}
    <ul class="shipping-rates selected">
      <li>
        <label title="">
          <span class="value"></span>
          <span class="rate-title"></span>
          <div class="rate-description"></div>
        </label>

        <div class="clear"></div>
        <span class="change">{t(#Change#)}</span>
      </li>
    </ul>

    <widget class="XLite\View\FormField\Select\ShippingMethod" disableSearch="true" fieldName="{getFieldName())}" options="{getMethodsAsList()}" value="{selectedMethod.methodId}" fieldOnly="true" label="{t(#Shipping rates#)}" />
    <ul style="display:none" class="shipping-rates-data">
      {foreach:getRates(),rate}
        <li id="shippingMethod{getMethodId(rate)}">
          <span class="name" title="{getMethodName(rate):h}">{getMethodName(rate):h}<img src="images/spacer.gif" alt="" class="fade-a" /></span>
          <span class="value"><widget class="XLite\View\Surcharge" surcharge="{getTotalRate(rate)}" currency="{cart.getCurrency()}" /></span>
          <span class="description">{getMethodDeliveryTime(rate)}</span>
        </li>
      {end:}
    </ul>

  {else:}
    <ul class="shipping-rates">
      <li FOREACH="getRates(),rate">
        <div class="radio">
          <label title="{getMethodName(rate)}">
            <input type="radio" id="method{getMethodId(rate)}" name="{getFieldName()}" value="{getMethodId(rate)}" checked="{isRateSelected(rate)}" />
            <span class="value"><widget class="XLite\View\Surcharge" surcharge="{getTotalRate(rate)}" currency="{cart.getCurrency()}" /></span>
            <span class="rate-title">{getMethodName(rate):h}</span>
            <div IF="{getMethodDeliveryTime(rate)}" class="rate-description">{getMethodDeliveryTime(rate)}</div>
          </label>
        </div>
      </li>
    </ul>
  {end:}
</div>