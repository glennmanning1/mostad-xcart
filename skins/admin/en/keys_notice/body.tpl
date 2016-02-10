{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * License keys notice popup dialog
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="keys-notice-form">

  <widget class="\XLite\View\Button\Link" label="Re-check" location="{getRecheckURL()}" style="recheck-license"/>

  <div class="title">{t(#License warning#)}</div>

  {if:isCoreWarning()}

  <div class="indent">{t(#The system has detected that the license key that was activated for your store is invalid.#):h}</div>

  <ul class="modules-list license-key">
    <li class="module-info">
      <div class="module-name">{coreLicense.title}</div>
      <div class="module-reason">{coreLicense.message:h}</div>
      <div class="module-action"><a IF="coreLicense.url" href="{coreLicense.url}" href="_blank">{t(#Purchase#)}</a></div>
    </li>
  </ul>

  <div IF="getUnallowedModules()" class="indent">{t(#Also the system has detected problems with the following modules#):h}</div>

  {else:}

  <div IF="isFraudStatusConfirmed()" class="alert alert-warning">{t(#Unallowed modules will be disabled automatically on the next visit any page in the administrator interface.#):h}</div>

  <div class="indent">{t(#The system has detected one or more problems with some of the modules at your store:#):h}</div>
  <ul class="indent">
    <li>{t(#inactive license key(s);#):h}</li>
    <li>{t(#installed module(s) not allowed by the type of X-Cart license activated at your store.#):h}</li>
   </ul>

  <div class="indent">{t(#Using the modules with this type of license violation is illegal#):h}</div>

 {end:}

  <ul class="modules-list">
    <li FOREACH="getUnallowedModules(),module" class="module-info">
      <div class="module-name">{module.title}</div>
      <div class="module-reason">{module.message:h}</div>
      <div class="module-action"><a IF="module.url" href="{module.url}" target="_blank">{t(#Purchase#)}</a></div>
    </li>
  </ul>

  <div class="indent buttons">

    {if:isDisplayPurchaseAllButton()}
    <widget class="\XLite\View\Button\Link" label="Purchase license" location="{getPurchaseAllURL()}" blank="true" style="purchase regular-main-button" />
    {end:}

    <widget IF="!hasLicense()" class="XLite\View\Button\ActivateKey" />
    <widget IF="hasLicense()" class="\XLite\View\Button\Addon\EnterLicenseKey" />

    <div class="text or">{t(#or#)}</div>

    <a IF="isCoreWarning()" href="{getBackToTrialURL()}">{t(#Back to Trial mode#)}</a>
    <a IF="!isCoreWarning()" href="{getRemoveModulesURL()}">{t(#Remove unlicensed modules#)}</a>

  </div>

  <div class="indent contact-us text">
    {t(#You can also contact our CR department for help with this issue#,_ARRAY_(#url#^getContactUsURL())):h}
  </div>

  <div class="clear"></div>

</div>
