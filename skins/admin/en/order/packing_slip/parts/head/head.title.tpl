{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice : header : address box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="packing_slip.head", weight="10")
 *}

<td class="title-wrapper">
    <div class="packing-slip-title">{getPackingSlipTitle()} {order.getPrintableOrderNumber()}</div>
    <div class="packing-slip-title-data">
        <div class="packing-slip-title-data-item packing-slip-packing-date">
            <strong class="date-title">{t(#Packing date#)}</strong>
            <span class="date-value">{getPackingSlipDateTime()}</span>
        </div>
        <div class="packing-slip-title-data-item packing-slip-shipping-method">
            <strong class="date-title">{t(#Shipping#)}</strong>
            <span class="date-value">{getShippingMethodName()}</span>
        </div>
        <div class="packing-slip-title-data-item packing-slip-order-date">
            <strong class="date-title">{t(#Order date#)}</strong>
            <span class="date-value">{formatTime(order.getDate())}</span>
        </div>
        <div FOREACH="order.getPaymentTransactionData(1),item" class="packing-slip-title-data-item payment-sub-data">
            <strong class="date-title">{t(item.title)}</strong>
            <span class="date-value">{item.value}</span>
        </div>
    </div>
</td>
