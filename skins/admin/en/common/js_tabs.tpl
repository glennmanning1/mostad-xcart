{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tabber template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<h1 IF="getTitle()">{t(getTitle())}</h1>

<div class="tabbed-content-wrapper js-tabs">
  <div class="tabs-container">
    <div class="page-tabs" IF="isTabsNavigationVisible()">

      <ul role="tablist">
        <li FOREACH="getTabs(),tab,tabPage" class="tab" role="presentation">
          <a href="{tabPage.url:h}" aria-controls="{tab}" role="tab" data-toggle="tab">{t(tabPage.title)}</a>
        </li>
        <list name="tabs.items" />
      </ul>
    </div>
    <div class="tab-content">
      <div FOREACH="getTabs(),tab,tabPage" role="tabpanel" class="tab-pane" id="{tab}">
        <list name="tabs.content" />
        <widget template="{getTabTemplate(tabPage)}" IF="isTemplateOnlyTab(tabPage)" />
        <widget class="{getTabWidget(tabPage)}" IF="isWidgetOnlyTab(tabPage)" />
        <widget class="{getTabWidget(tabPage)}" template="{getTabTemplate(tabPage)}" IF="isFullWidgetTab(tabPage)" />
        <widget template="{getPageTemplate(tabPage)}" IF="isCommonTab(tabPage)" />
      </div>
    </div>
  </div>
</div>
