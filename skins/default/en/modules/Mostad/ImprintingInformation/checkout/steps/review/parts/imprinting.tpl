{**
 * @ListChild (list="checkout.review.selected.items", weight="5")
 * @ListChild (list="checkout.review.inactive.items", weight="5")
 *}
<div IF="cartHasItemsNeedingImprinting()" class="items-row clearfix imprinting-review">
    <h4>Imprinting Information</h4>
    <ul>
        <li IF="getImprintingFirmName()">{getImprintingFirmName()}</li>
        <li IF="getImprintingDesignation()">{getImprintingDesignation()}</li>
        <li IF="getImprintingAddress()">{getImprintingAddress()}</li>
        <li IF="getImprintingAddress2()">{getImprintingAddress2()}</li>
        <li IF="getImprintingCityStateZip()">{getImprintingCityStateZip()}</li>
        <li IF="getImprintingEmail()">{getImprintingEmail()}</li>
        <li IF="getImprintingWebsite()">{getImprintingWebsite()}</li>
    </ul>
    <p><button onclick="window.location.href='/?target=imprinting'">Change Imprinting Information</button></p>
    <hr>
</div>
