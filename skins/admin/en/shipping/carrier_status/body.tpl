{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="shipping-status" data-processor="{getProcessor()}">
  <div class="{getClass()}" role="alert">
    {if:isSwitchable()}
    <widget
      class="XLite\View\FormField\Input\Checkbox\OnOff"
      label="This shipping method is"
      fieldName="shipping_method_status"
      onLabel="{t(#shippingStatus.Active#)}"
      offLabel="{t(#shippingStatus.Inactive#)}"
      value="{isEnabled()}" />
    {else:}
    <div class="table-label">
      <label>{t(#This shipping method is not configured.#):h}</label>
    </div>
    {end:}
  </div>

  <div IF="getSignUpURL()" class="sign-up">
    {t(#Dont have account yet?#)}
      <a href="{getSignUpURL()}" target="_blank">{t(#Sign Up Now#)}</a>
  </div>
</div>
