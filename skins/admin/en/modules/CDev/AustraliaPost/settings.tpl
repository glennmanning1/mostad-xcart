{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * AustraliaPost settings page main template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="shipping-description">
  <strong>Australia Post</strong> module allows to use online shipping rates calculation via <a href="http://auspost.com.au/devcentre/pacpcs.html" target="_new">Postage Assessment Calculation service</a>.
  <br />Please note that rates are calculated for shipping from Australian locations only.

  <br /><br />

  {if:config.CDev.AustraliaPost.optionValues}
  {else:}
  <br />{t(#Before you can start configure Australia Post module you should update available options from Australia Post. Please click button below.#)}
  {end:}
</div>
<widget class="XLite\Module\CDev\AustraliaPost\View\Model\Settings" />

