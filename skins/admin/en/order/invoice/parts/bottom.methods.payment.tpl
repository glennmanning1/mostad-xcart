{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice payment methods
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.address.billing", weight="20")
 *}
<div class="method-box">
  <strong class="method-title">{t(#Payment method#)}</strong>
  {if:order.getVisiblePaymentMethods()}
    {foreach:order.getVisiblePaymentMethods(),m}
      {m.getTitle():h}<br />
    {end:}
  {elseif:order.getPaymentMethodName()}
    {t(order.getPaymentMethodName()):h}<br />
  {else:}
    {t(#n/a#)}<br />
  {end:}
  {if:order.getPaymentTransactionId()}
    {t(#Transaction ID#)}: {order.getPaymentTransactionId()}
  {end:}
  <div FOREACH="order.getPaymentTransactionData(1),item" class="sub-data">
    <strong class="title">{t(item.title)}</strong>
    <span class="value">{item.value}</span>
  </div>
</div>
