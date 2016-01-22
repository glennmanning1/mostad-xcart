{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Payment\MethodStatus" />

<div class="payment-settings {paymentMethod.getServiceName()}">

  <div class="middle">

    <widget class="\XLite\Module\CDev\Paypal\View\Model\PaypalAdaptive" paymentMethod="{getPaymentMethod()}" />

    <div class="help">
      <div class="logo-ppa"></div>

      <div class="help-title">Accept Payments Directly on Your Site</div>

      <div class="help-text">Accept Visa, MasterCard&reg;, American Express, Discover, and PayPal payments.</div>
      <div class="help-text">In the current implementation of PayPal Adaptive Payments for X-Cart, fees for using the service are charged by PayPal based on the "Primary Receiver Pays the Fee in a Chained Payment" model. This means that only the administrator, who is the primary receiver, pays the fee in a chained payment, whereas other receivers - vendors - pay no fees. The fees paid by the administrator, however, are based upon the total fees assigned to all receivers.</div>

      <div class="links">
        <div class="help-link">Don't have an account? <span class="external"><a href="{paymentMethod.getReferralPageURL()}" target="_blank">Sign Up Now</a> <i class="icon fa fa-external-link"></i></span></div>
        <div class="help-link" FOREACH="paymentMethod.getKnowledgeBasePageURLs(),link">
          <span class="external"><a href="{link.url}" target="_blank">{link.name}</a> <i class="icon fa fa-external-link"></i></span>
        </div>
      </div>

      <div class="help-text"><span class="external"><a href="{paymentMethod.getPartnerPageURL()}" target="_blank">Get more information</a> <i class="icon fa fa-external-link"></i></span></div>

    </div>

  </div>

</div>
