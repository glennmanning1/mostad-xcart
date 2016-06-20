{if:getPageBody()}
    {getPageBody():h}
{else:}

<div class="contact-us-description">
    <h3>Get started now!</h3>
    <p>Effective marketing has the power to build the kind of accounting practice you want.</p>
    <p>Request your FREE Smart Marketing for Accountants today. You'll also get 46 Marketing Ideas for Accountants — a guide of practical and profitable ideas to increase the success of your firm's marketing efforts.</p>
    <p><strong>Fill out the form below to request your FREE copy</strong></p>
</div>

<hr class="contact-us-description-hr"/>
{end:}
<widget class="\XLite\Module\Mostad\Contact\View\Form\ContactForm" name="contact_request"/>

<div id="contact_request">

    <div id="contact-site-form">
        <div class="form-item">
            <label for="name">
                Name <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Full Name#)}" fieldName="name" value="{getValue(#name#)}" fieldOnly="true" required="true"/>
        </div>

        <div class="form-item">
            <label for="firmName">
                Firm Name <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Firm Name#)}" fieldName="firmName" value="{getValue(#firmName#)}" fieldOnly="true" required="true"/>
        </div>


        <div class="form-item">
            <label for="email">
                Email <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text\Email" placeholder="{t(#Email Address#)}" fieldName="email" value="{getValue(#email#)}" fieldOnly="true" required="true"/>
        </div>

        <div class="form-item">
            <label for="phone">
                Phone Number
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Phone Number#)}" fieldName="phone" value="{getValue(#phone#)}" fieldOnly="true" required="false"/>
        </div>

        <div class="form-item">
            <label for="fax">
                Fax Number
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Fax Number#)}" fieldName="fax" value="{getValue(#fax#)}" fieldOnly="true" required="false"/>
        </div>

        <div class="form-item">
            <label for="address">
                Mailing address <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Mailing Address#)}" fieldName="address" value="{getValue(#address#)}" fieldOnly="true" required="true"/>
        </div>

        <div class="form-item">
            <label for="address2">
                Address 2
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Address 2#)}" fieldName="address2" value="{getValue(#address2#)}" fieldOnly="true" required="false"/>
        </div>

        <div class="form-item">
            <label for="city">
                City <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#City#)}" fieldName="city" value="{getValue(#city#)}" fieldOnly="true" required="true"/>
        </div>

        <div class="form-item">
            <label for="state">
                State <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="\XLite\View\FormField\Select\State" fieldName="state" value="{getValue(#state#)}" fieldOnly="true" required="true" country="US" />
        </div>

        <div class="form-item">
            <label for="zipcode">
                Zipcode <span class="form-required" title="This field is required.">*</span>
            </label>
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Zipcode#)}" fieldName="zipcode" value="{getValue(#zipcode#)}" fieldOnly="true" required="true"/>
        </div>

        <div class="form-item">
            <label for="firmType">
                My firm type
            </label>
            <widget class="\XLite\Module\Mostad\Contact\View\FormField\Select\FirmType" fieldName="firmType" value="{getValue(#firmType#)}" required="false" />
            <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Other firm type#)}" fieldName="firmTypeOther" value="{getValue(#firmTypeOther#)}" fieldOnly="true" required="false"/>
        </div>


        <div class="form-item">
            <label for="publicPractice">
                In Public Practice
            </label>
            <widget class="XLite\View\FormField\Select\YesNoEmpty" fieldName="publicPractice" value="{getValue(#publicPractice#)}" labe="blah" fieldOnly="false" required="false"/>
        </div>

        <div class="form-item">
            <label for="source">
                I found M&C's website by:
            </label>
            <widget class="\XLite\Module\Mostad\Contact\View\FormField\Select\FoundWebsiteBy" fieldName="source" value="{getValue(#source#)}" required="false" />
        </div>

        <div class="form-item">
            <label for="message" class="for-message">
                Comments or Questions
            </label>

            <div class="resizable-textarea">
                <widget class="XLite\View\FormField\Textarea\Simple" placeholder="{t(#Your Message#)}" fieldName="message" value="{getValue(#message#)}" fieldOnly="true" required="false"/>
            </div>
        </div>

        <div class="form-item">
            {getCaptcha():h}
        </div>

        <div class="form-action">
            <button type="submit" class="btn  regular-button  submit">
                <span>Send</span>
            </button>
        </div>

        <widget class="XLite\View\FormField\Input\Hidden" fieldName="page-title" value="{getPageId()}" fieldOnly="true" required="false"/>

    </div>


</div>

<widget name="contact_request" end/>
