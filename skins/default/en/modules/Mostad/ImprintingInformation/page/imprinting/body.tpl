{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Imprinting page template
 *  
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *}
{*<widget class="XLite\Module\Mostad\ImprintingInformation\View\Model\Imprinting" useBodyTemplate="1">
</widget>*}

<div id="imprinting-form" class="container-fluid">
    <div class="row header">
        <div class="col-md-12">
            <h3>Imprint and Display Information:</h3>
        </div>
    </div>
    <widget class="XLite\Module\Mostad\ImprintingInformation\View\Form\Model\Imprinting" name="imprinting_information"/>
    <div class="row">
        <div class="col-md-6 status">
            <widget class="XLite\Module\Mostad\ImprintingInformation\View\FormField\ImprintingStatus" fieldName="status"
                    fieldOnly="true" required="true"/>
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
                <widget class="XLite\Module\Mostad\ImprintingInformation\View\FormField\Address" fieldName="address"
                        attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
            </div>
            <div class="form-item">
                <widget class="XLite\View\FormField\Input\Text\Email" fieldName="email" label="E-mail"
                        attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
            </div>
            <div class="form-item">
                <widget class="XLite\View\FormField\Input\Text\URL" fieldName="website" label="Website"
                        attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
            </div>
            <div class="form-checkbox">
                <label for="addLogo">
                    <widget class="XLite\View\FormField\Input\Checkbox\Enabled" value="0" fieldName="addLogo"
                            fieldOnly="true" attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
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
                Internet link products have an area for your firm name and e-mail address. Please indicate the
                information you'd like displayed.
            </p>
            <div class="form-item">
                <widget class="XLite\View\FormField\Input\Text\Email" fieldName="onlineEmail" label="E-mail"
                        attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
            </div>
            <div class="form-item">
                <widget class="XLite\View\FormField\Input\Text\URL" fieldName="onlineWebsite" label="Website"
                        attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
            </div>
            <div class="form-checkbox">
                <label for="addLogo">
                    <widget class="XLite\View\FormField\Input\Checkbox\Enabled" fieldName="onlineAddLogo"
                            fieldOnly="true" value="0" attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
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
                    <widget class="XLite\View\FormField\Input\Checkbox\Enabled" fieldName="onlineAddToSite"
                            fieldOnly="true" value="0" attributes="{_ARRAY_(#class#^#disable-for-same#)}"/>
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
                    <widget class="XLite\View\FormField\Input\Checkbox\Enabled" fieldName="confirm" fieldOnly="true"/>
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
    <widget name="imprinting_information" end/>
</div>
