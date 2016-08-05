<li class="">
    <div class="table-label">
        <label>Address</label>
    </div>
    <div class="star">
        &nbsp;  </div>

    <div class="table-value">
        <ul class="address-entry">
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

    <widget class="\XLite\Module\Mostad\ImprintingInformation\View\Button\AddAddress" label="Add new address"  profileId="{getProfileId()}" />

</li>