{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : line 2
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.operations", weight="200")
 *}

<div class="line-2">
    <h3 class="h3">Imprinting Information</h3>
    <div class="row">
        <div class="col-md-12">
            <p>Status:
                    {if:order.imprinting.isNew()}
                    <strong>New</strong> - Add to the system
                    {elseif:order.imprinting.isUpdate()}
                    <strong>Update</strong> - update the system
                    This information will be updated in the system
                    {elseif:order.imprinting.isSame()}
                    <strong>Same</strong> - Use existing information
                    {end:}
                </p>
        </div>
    </div>
    {if:!order.imprinting.isSame()}
    <div class="row">
        <div class="col-md-6">
            <strong class="title">{t(#Imprinting Address Information#)}</strong>

            <ul class="address-section shipping-address-section">
                <li FOREACH="getImprintingAddressSectionData(order.imprinting),idx,field"
                    class="{field.css_class} address-field">
                    <span class="address-title">{t(field.title)}:</span>
                    <span class="address-field">{field.value}</span>
                    <span class="address-comma">,</span>
                </li>
                <li>
                    Email: {order.imprinting.email}
                </li>
                <li>
                    Website: {order.imprinting.website}
                </li>
                <li>
                    Add Logo?: {if:order.imprinting.addLogo}Yes{else:}No{end:}
                </li>
            </ul>
        </div>

        <div class="col-md-3">
            <strong class="sub-title">Online Product Imprinting Information</strong>
            <ul class="information-section">
                <li>
                    Firm Name: {order.imprinting.onlineFirmName}
                </li>
                <li>
                    Email: {order.imprinting.onlineEmail}
                </li>
                <li>
                    Website: {order.imprinting.onlineWebsite}
                </li>
                <li>
                    Add Logo?: {if:order.imprinting.onlineAddLogo}Yes{else:}No{end:}
                </li>
                <li>
                    Add to my website? {if:order.imprinting.onlineAddToSite}Yes{else:}No{end:}
                </li>
            </ul>
        </div>
    </div>
    {end:}
</div>