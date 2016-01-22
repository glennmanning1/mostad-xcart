{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Available
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="available-block-list">
  <li foreach="getAvailableModules(),module">
    <widget template="accounting/parts/available.module.tpl" moduleParam="{module}"/>
  </li>
  <li>
    <widget template="accounting/parts/available.module.tpl" moduleParam="{getExportNode()}"/>
  </li>
</ul>