<div class="">
    <div class="table-label">
        <label>Address</label>
    </div>
    <div class="star">&nbsp;</div>
    <widget class="\XLite\Module\Mostad\ImprintingInformation\View\Button\AddAddress" label="Add new address"  profileId="{getProfileId()}" />

    <div class="table-value">
        <ul class="address-entry list-inline">
            {displayCommentedData(getCommentedData())}
            {foreach:getOptions(),optionValue,address}
            <li class="imprinting-address">
                <label>
                    <input {getAttributesCode():h} {getOptionAttributesCode(optionValue,optionLabel):h} />
                    <widget template="select_address/address.tpl" address="{address}"/>
                </label>
            </li>
            {end:}
        </ul>
    </div>


</div>