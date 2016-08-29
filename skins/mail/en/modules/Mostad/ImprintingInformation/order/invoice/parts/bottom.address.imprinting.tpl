{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice imprinting address
 * @ListChild (list="invoice.bottom.address.imprinting", weight="20")
 *}
<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">{t(#Imprinting information#)}</strong>
<br/>
<strong>
    {if:imprinting.isNew()}
    This information will be added to the system
    {elseif:imprinting.isUpdate()}
    This information will be updated in the system
    {elseif:imprinting.isSame()}
    We will use the information in the system
    {end:}
</strong>

{if:!imprinting.isSame()}

<ul style="padding-top: 12px;list-style: none;margin: 0;padding-left: 0;margin-left: 0px;margin-bottom:0px;">
    <li FOREACH="getImprintingAddressSectionData(imprinting),idx,field"
        style="padding-right: 4px;white-space: nowrap;margin-left: 0px;"
        class="{field.css_class} address-field">
        <span style="font-size: 14px;line-height: 20px;padding-top: 8px;color: #000;"
              class="address-title">{t(field.title)}:</span>
        <span style="font-size: 14px;line-height: 20px;padding-top: 8px;color: #000;"
              class="address-field">{field.value}</span>
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Email: {imprinting.email}
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Website: {imprinting.website}
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Add Logo?: {if:imprinting.addLogo}Yes{else:}No{end:}
    </li>
</ul>

<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">Online Product Imprinting
    Information</strong>
<ul style="padding-top: 12px;list-style: none;margin: 0;padding-left: 0;margin-left: 0px;margin-bottom:0px;">
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Email: {imprinting.onlineEmail}
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Website: {imprinting.onlineWebsite}
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Add Logo?: {if:imprinting.onlineAddLogo}Yes{else:}No{end:}
    </li>
    <li style="padding-right: 4px;white-space: nowrap; margin-left: 0px;">
        Add to my website? {if:imprinting.onlineAddToSite}Yes{else:}No{end:}
    </li>
</ul>
{end:}