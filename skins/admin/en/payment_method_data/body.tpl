{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment transaction page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getContainerAttributes()):h}>

  <widget class="XLite\View\Form\Order\PaymentMethodData" name="modifyPaymentData" />

  <input type="hidden" name="transaction_id" value="{getTransactionId()}" />
  <div class="payment-method-data-orig-values">
    <input FOREACH="getFieldValues(),w" type="hidden" name="{w.name}" value="{w.value}" />
  </ul>

  <div class="payment-method-data-fields">
    <widget class="\XLite\View\PaymentMethodDataTemplate" />
  </div>

  <widget class="\XLite\View\Button\Submit" label="{t(#Update#)}" />

  <widget name="modifyPaymentData" end />

</div>
