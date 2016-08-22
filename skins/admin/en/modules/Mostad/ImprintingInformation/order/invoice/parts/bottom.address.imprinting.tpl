{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice imprinting address
 * @ListChild (list="invoice.bottom.address.imprinting", weight="20")
 *}
<strong class="title">{t(#Imprinting information#)}</strong>

<ul class="address-section shipping-address-section">
  <li FOREACH="getAddressSectionData(imprinting.address),idx,field" class="{field.css_class} address-field">
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
        Add Logo?: {imprinting.addLogo}
    </li>
</ul>

<strong class="sub-title">Online Product Imprinting Information</strong>
<ul class="information-section">
    <li>
        Email: {imprinting.onlineEmail}
    </li>
    <li>
        Website: {imprinting.onlineWebsite}
    </li>
    <li>
        Add Logo?: {imprinting.onlineAddLogo}
    </li>
</ul>