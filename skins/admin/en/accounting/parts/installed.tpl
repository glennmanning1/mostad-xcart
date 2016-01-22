{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Installed
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="installed-block-list-wrapper">
  <ul class="installed-block-list">
    <li foreach="getInstalledModules(),module" class="installed-module">
      <widget template="accounting/parts/installed.module.tpl" moduleParam="{module}"/>
    </li>
  </ul>
</div>