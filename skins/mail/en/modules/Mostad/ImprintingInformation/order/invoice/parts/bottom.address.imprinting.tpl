{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice imprinting address
 * @ListChild (list="invoice.bottom.address.imprinting", weight="20")
 *}
<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">{t(#Imprinting information#)}</strong>

<ul style="padding-top: 12px;list-style: none;margin: 0;padding-left: 0;margin-left: 0px;margin-bottom:0px;">
  {foreach:getAddressSectionData(imprinting.address),idx,field}
  <widget IF="{getAddressFiledTemplate(#b#,idx,field)}" template="{getAddressFiledTemplate(#b#,idx,field)}" field="{field}" />
  {end:}
</ul>

<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">Print Product Imprinting Information</strong>

<ul style="padding-top: 12px;list-style: none;margin: 0;padding-left: 0;margin-left: 0px;margin-bottom:0px;">
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

<strong style="color: #000;font-size: 20px;font-weight: normal;padding-bottom: 3px;">Online Product Imprinting Information</strong>
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