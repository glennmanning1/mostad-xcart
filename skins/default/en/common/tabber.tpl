{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tabber template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="head-h2" IF="head">{t(head)}</div>
<div class="tabbed-content-wrapper">
  <div class="tabs-container">
    <div class="page-tabs {getTabPageCSS()}">
      <ul>
        <li FOREACH="getTabberPages(),tabPage" class="tab{if:tabPage.selected}-current active{end:}">
          <a href="{tabPage.url}">{t(tabPage.title)}</a>
        </li>
      </ul>
    </div>
    <div class="clear"></div>

    <div class="tab-content">
      <widget template="{getParam(#body#)}" />
    </div>
  </div>
</div>
