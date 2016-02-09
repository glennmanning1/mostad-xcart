{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Base template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget IF="isUseFilter()" template="search_panel/filters.tpl" />

<div class="title-margin"></div>

<widget class="{getFormClass()}" name="search_form" className="{getContainerClass()}" />

  <list name="before" type="nested" />

  <div class="search-conditions-box">

    {displayCommentedData(getSearchPanelParams())}

    <ul class="search-conditions clear clearfix">
      {foreach:getConditions(),name,condition}
        <li class="{name}-condition">{condition.display()}</li>
      {end:}
      <li class="actions">
        {foreach:getActions(),name,action}
          {action.display()}
        {end:}
        <list name="actions" type="nested" />
      </li>
      <list name="conditions" type="nested" />
    </ul>

    <span IF="getHiddenConditions()" class="search-conditions-hr">
      <hr noshade class="line1 search-conditions-hidden">
      <hr noshade class="line2 search-conditions-hidden">
    </span>

    <ul IF="getHiddenConditions()" class="search-conditions-hidden clear clearfix">
      {foreach:getHiddenConditions(),name,condition}
        <li class="{name}-condition {getRowClass(conditionArrayPointer,#odd#,#even#)}">{condition.display()}</li>
      {end:}
      <list name="hiddenConditions" type="nested" />
    </ul>

    <div IF="getHiddenConditions()" class="arrow"></div>

    <widget IF="isUseFilter()" class="\XLite\View\Button\SaveSearchFilter" />

  </div>

  <list name="after" type="nested" />

<widget name="search_form" end />
