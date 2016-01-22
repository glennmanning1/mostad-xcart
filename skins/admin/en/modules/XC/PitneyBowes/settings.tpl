{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Settings page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="shipping-description">
  <p>{t(#Pitney Bowes module allows to use online shipping rates calculation via Pitney Bowes ClearPath service.#):h}</p>

  {if:!isCredentialsRequested()}
  <p>{t(#Before you can start configuring Pitney Bowes module you should request your personal credentials from Pitney Bowes. Please click the "Request credentials" button below.#)}</p>
  <p>{t(#If you already have PB credentials, click the "Show settings" button below to open the settings form.#)}</p>
  <widget class="XLite\View\Form" name="not_configured_form" />
  	<widget class="XLite\Module\XC\PitneyBowes\View\StickyPanel\NotConfigured" />
  <widget name="not_configured_form" end />
  {end:}
</div>

{if:isCredentialsRequested()}
<widget class="XLite\Module\XC\PitneyBowes\View\Model\Settings" />
{end:}

