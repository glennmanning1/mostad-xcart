{**
 * @ListChild (list="checkout.review.selected.items", weight="5")
 * @ListChild (list="checkout.review.inactive.items", weight="5")
 *}
<div IF="cartHasItemsNeedingImprinting()" class="items-row clearfix imprinting-review">
    <h4>Imprinting Information</h4>
    <ul>
        <li IF="getImprintingFirmName()">{getImprintingFirmName()}</li>
        <li>John TODO</li>
        <li>123 TODO St</li>
        <li>TODO, MN 55432</li>
        <li>320-203-TODO</li>
        <li>230-230-TODO</li>
        <li IF="getImprintingEmail()">{getImprintingEmail()}</li>
        <li IF="getImprintingWebsite()">{getImprintingWebsite()}</li>
    </ul>
    <p><button onclick="window.location.href='/?target=imprinting'">Change Imprinting Information</button></p>
    <hr>
</div>
