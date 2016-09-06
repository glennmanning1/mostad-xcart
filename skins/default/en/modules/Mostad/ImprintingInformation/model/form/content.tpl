{*<div FOREACH="getFormFieldsForDisplay(),section,data" class="section {section}-section">
  <div class="header {section}-header" IF="{isShowSectionHeader(section)}">{data.sectionParamWidget.display()}</div>
  <ul class="table {section}-table">
    <li FOREACH="data.sectionParamFields,field" class="{field.getWrapperClass()} {getItemClass(fieldArrayPointer,fieldArraySize,field)}">
      {displayCommentedData(getFieldCommentedData(field))}
      {field.display()}
    </li>
  </ul>
</div>*}

<div class="row">
    <div class="col-md-6 status">
        {displayField(#default#,#status#)}
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-6">
        <p><strong>Imprint Information (for printed products, e-brochures, and e-newsletters)</strong><br/>
            Your imprint will be typeset as shown on products on this website. If you have special imprinting needs,
            please contact us.
        </p>
        <div class="form-item">
            {displayField(#default#,#firmName#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#designation#)}
            <span>(Example: Certified Public Accountant)</span>
        </div>
        <div class="form-item">
            {displayField(#default#,#name#)}
            <span>For business cards only</span>
        </div>
        <div class="form-item">
            {displayField(#default#,#address#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#address2#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#city#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#state#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#zip#)}
        </div>

        <div class="form-item">
            <div class="table-label phone-label">
                <label for="phone">
                    Phone
                </label>
            </div>
            <div class="star">
                &nbsp;
            </div>
            {displayField(#default#,#phoneCode#)}
            {displayField(#default#,#phone#)}
            <div class="clear"></div>
        </div>
        <div class="form-item">
            <div class="table-label phone-label">
                <label for="phone">
                    FAX
                </label>
            </div>
            <div class="star">
                &nbsp;
            </div>
            {displayField(#default#,#faxCode#)}
            {displayField(#default#,#fax#)}
            <div class="clear"></div>
        </div>
        <div class="form-item">
            {displayField(#default#,#email#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#website#)}
        </div>
        <div class="form-checkbox">
            <label for="addLogo">
                {displayField(#default#,#addLogo#)}
                Add logo to my imprint — $40<br/>
                <a class="dialog-trigger" href="#" data-target="imprint-details">click for details</a>
                <div id="imprint-details" class="dialog-target redCheck">
                    <div class="dialog-header">&nbsp;</div>
                    <div class="dialog-content">
                        <p><strong>To have your logo imprinted in black ink on brochures or newsletters:</strong>
                        </p>
                        <br/>
                        <ul>
                            <li>Email your logo to <a href="mailto:service@mostad.com">service@mostad.com</a></li>
                            <li>Acceptable file formats: .eps or .tif</li>
                            <li>Minimum resolution: 300 dpi</li>
                            <li>Note: Logos not available on postcards.</li>
                        </ul>
                        <p><br/>A one-time logo setup fee of $40 will be added to your total when we process your
                            order.</p>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <div class="col-md-6">
        <p>
            <strong>Display Information (for online products)</strong><br/>
            Internet link products have an area for your firm name and email address. Please indicate the
            information you'd like displayed.
        </p>
        <div class="form-item">
            {displayField(#default#,#onlineFirmName#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#onlineEmail#)}
        </div>
        <div class="form-item">
            {displayField(#default#,#onlineWebsite#)}
            <span>So we can incorporate a link back to your site.</span>
        </div>
        <div class="form-checkbox">
            <label for="addLogo">
                {displayField(#default#,#onlineAddLogo#)}
                Add logo to my imprint — $40<br/>
                <a class="dialog-trigger" href="#" data-target="display-details">click for details</a>
                <div id="display-details" class="dialog-target redCheck">
                    <div class="dialog-header">&nbsp;</div>
                    <div class="dialog-content">
                        <p><strong>To have your logo displayed on online link products:</strong></p>
                        <br/>
                        <ul>
                            <li>Email your logo to <a href="mailto:service@mostad.com">service@mostad.com</a></li>
                            <li>Acceptable file formats: .jpg, .gif, .tif</li>
                            <li>Note: Logo display not available on The Reference Section or the Information
                                Station.
                            </li>
                        </ul>
                        <p><br/>A one-time setup fee of $40 will be added to your total when we process your order.
                        </p>
                    </div>
                </div>
            </label>
        </div>
        <p>If M&C created or edits your website, we can add Internet link products to your site for an additional
            fee.</p>
        <div class="form-checkbox">
            <label for="onlineAddtoSite">
                {displayField(#default#,#onlineAddToSite#)}
                I want M&C to add link products to my site — $20<br/>
                (fee will be added to your final invoice)
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="form-checkbox">
            <label for="confirm">
                {displayField(#default#,#confirm#)}
                <strong>I have reviewed my imprint information above and verified that it is correct.</strong>
            </label>
        </div>
        <div class="form-action">
            <button type="submit" class="btn  regular-button  submit">
                <span>Save Imprinting Information</span>
            </button>
        </div>
    </div>
</div>
