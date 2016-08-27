{**
 * @ListChild (list="checkout.review.selected.items", weight="5")
 * @ListChild (list="checkout.review.inactive.items", weight="5")
 *}
<div IF="cartHasItemsNeedingImprinting()" class="items-row clearfix imprinting-review">
    <h4>Imprinting Information</h4>
    <strong>
        {if:isImprintingNew()}
        This information will be added to the system
        {elseif:isImprintingUpdate()}
        This information will be updated in the system
        {elseif:isImprintingSame()}
        We will use the information in the system
        {end:}
    </strong>

    {if:!isImprintingSame()}
    <ul>
        <li IF="getImprintingFirmName()">{getImprintingFirmName()}</li>
        <li IF="getImprintingDesignation()">{getImprintingDesignation()}</li>
        <li IF="getImprintingAddress()">{getImprintingAddress()}</li>
        <li IF="getImprintingAddress2()">{getImprintingAddress2()}</li>
        <li IF="getImprintingCityStateZip()">{getImprintingCityStateZip()}</li>
        <li IF="getImprintingEmail()">{getImprintingEmail()}</li>
        <li IF="getImprintingWebsite()">{getImprintingWebsite()}</li>
    </ul>
    {end:}
    <p>
        <button onclick="window.location.href='/?target=imprinting'">Change Imprinting Information</button>
    </p>
    <hr>
</div>
