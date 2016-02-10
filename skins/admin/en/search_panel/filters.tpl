{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Search filters template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="saved-filter-options">

  <li FOREACH="getSavedFilterOptions(),fid,filter" class="filter-option filter-{fid}">
    {if:fid}
      {if:isSelectedFilter(fid)}
         <span class="filter-title">{filter.getName()}</span>
      {else:}
         <a href="{buildURL(getTarget(),#search#,_ARRAY_(#filter_id#^fid))}" class="filter-title">{filter.getName()}</a>
      {end:}
      <span IF="filter.getSuffix()" class="filter-suffix">{filter.getSuffix()}</span>
      <a IF="isFilterRemovable(filter)" href="{buildURL(getTarget(),#delete_search_filter#,_ARRAY_(#filter_id#^fid))}" class="delete-filter fa fa-times" title="{t(#Delete filter option#)}"></a>
    {else:}
      <a href="{buildURL(getTarget(),#clearSearch#)}" class="filter-title first">{filter.getName()}</a>
    {end:}
  </li>
</ul>
