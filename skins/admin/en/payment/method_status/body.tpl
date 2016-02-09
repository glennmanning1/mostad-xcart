{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="payment-status" data-method="{getMethodId()}">
  <div class="{getClass()}" role="alert">
    <span class="status-message-before">
      <list name="{getBeforeListName()}" />
    </span>

    {if:isSwitchable()}
    <widget
      class="XLite\View\FormField\Input\Checkbox\OnOff"
      label="This payment method is"
      fieldName="payment_method_status"
      onLabel="{t(#shippingStatus.Active#)}"
      offLabel="{t(#shippingStatus.Inactive#)}"
      value="{isEnabled()}" />
    {else:}
    <div class="table-label">
      <label>{t(#This payment method is not configured.#):h}</label>
    </div>
    {end:}

    <span class="status-message-after">
      <list name="{getAfterListName()}" />
    </span>
  </div>
</div>
