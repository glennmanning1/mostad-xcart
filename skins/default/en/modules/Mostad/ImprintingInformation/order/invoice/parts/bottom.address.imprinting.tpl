{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice imprinting address
 * @ListChild (list="invoice.bottom.address.imprinting", weight="20")
 *}
<strong class="title">{t(#Imprinting information#)}</strong>
<br />

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
<ul class="address-section shipping-address-section">
  <li FOREACH="getImprintingAddressSectionData(imprinting),idx,field" class="{field.css_class} address-field">
    <span class="address-title">{t(field.title)}:</span>
    <span class="address-field">{field.value}</span>
    <span class="address-comma">,</span>
  </li>
</ul>

<strong class="sub-title">Print Product Imprinting Information</strong>

<ul class="information-section">
    <li>
        Email: {imprinting.email}
    </li>
    <li>
        Website: {imprinting.website}
    </li>
    <li>
        Add Logo?: {if:imprinting.addLogo}Yes{else:}No{end:}
    </li>
</ul>

<strong class="sub-title">Online Product Imprinting Information</strong>
<ul class="information-section">
    <li>
        Firm Name: {imprinting.onlineFirmName}
    </li>
    <li>
        Email: {imprinting.onlineEmail}
    </li>
    <li>
        Website: {imprinting.onlineWebsite}
    </li>
    <li>
        Add Logo?: {if:imprinting.onlineAddLogo}Yes{else:}No{end:}
    </li>
    <li>
        Add to my website? {if:imprinting.onlineAddToSite}Yes{else:}No{end:}
    </li>
</ul>
{end:}