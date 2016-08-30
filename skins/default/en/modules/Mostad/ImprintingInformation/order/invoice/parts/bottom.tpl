{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice bottom block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base", weight="50")
 *}
<ul cellspacing="0"
    class="addresses{if:order.isShippingSectionVisible()} S{end:}{if:order.isPaymentSectionVisible()} B{end:}">

    <li IF="order.isPaymentSectionVisible()"
        class="address payment{if:order.isShippingSectionVisible()} payment-wrapping{end:}">
        <div class="wrapper">
            <list name="invoice.bottom.address.billing" baddress="{order.profile.billing_address}"
                  saddress="{order.profile.shipping_address}"/>
        </div>
    </li>

    <li IF="order.isShippingSectionVisible()" class="address shipping">
        <div class="wrapper{if:!order.trackingNumbers.isEmpty()} tracking-info-section-included{end:}">
            <list name="invoice.bottom.address.shipping" baddress="{order.profile.billing_address}"
                  saddress="{order.profile.shipping_address}"/>
        </div>
    </li>

    {if:order.imprinting}
    <li class="address imprinting">
        <div class="wrapper">
            <list name="invoice.bottom.address.imprinting" imprinting="{order.imprinting}"/>
        </div>
    </li>
    {end:}

    <li FOREACH="getViewList(#invoice.bottom#,_ARRAY_(#order#^order)),w">{w.display()}</li>

</ul>
