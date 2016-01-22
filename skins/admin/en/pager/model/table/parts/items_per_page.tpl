{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Items per page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="pager.admin.model.table.left", weight="400")
 *}
<div class="items-per-page-wrapper" IF="isItemsPerPageVisible()">
  <div class="search-total-items">
    {t(#<span>X</span> items#,_ARRAY_(#X#^getItemsTotal())):h}
  </div>
  <select name="itemsPerPage" class="page-length not-significant">
    <option FOREACH="getItemsPerPageRanges(),range" value="{range}" selected="{isRangeSelected(range)}">{range}</option>
  </select>
  <span>{t(#per page#)}</span>
</div>
