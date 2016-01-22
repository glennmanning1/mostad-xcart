{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Accounting landing page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="accounting-page-wrapper">
  <div class="installed-block">
    <widget template="accounting/parts/installed.tpl" />
  </div>
  <div class="description">
    {if:isConfigured()}
      <hr>
      <p>{t(#Want to change or add another accounting system? Choose the accounting system you require below and configure it.#):h}</p>
    {else:}
      <p>{t(#No accounting system has been selected yet. Choose your accounting system below and configure it.#):h}</p>
    {end:}
    <p>{t(#Not seeing your accounting software here? Let us know#,_ARRAY_(#href#^#http://ideas.x-cart.com/forums/229428-x-cart-5-x#)):h}</p>
  </div>

  <div class="available-block">
    <widget template="accounting/parts/available.tpl" />
  </div>
</div>