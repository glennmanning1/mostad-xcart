{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top categories tree
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<ul class="menu menu-tree{if:!isSubtree()} catalog-categories catalog-categories-tree{end:}">
  {foreach:getCategories(rootId),idx,_category}
    <li {displayItemClass(idx,_categoryArraySize,_category):h}>
      <a href="{_category.link}" {displayLinkClass(idx,_categoryArraySize,_category):h}>{_category.name}</a>
      <widget template="{getBody()}" rootId="{_category.id}" IF="_category.subcategoriesCount" is_subtree />
    </li>
  {end:}
  {foreach:getViewList(#topCategories.children#,_ARRAY_(#rootId#^getParam(#rootId#),#is_subtree#^getParam(#is_subtree#))),idx,w}
    <li {displayListItemClass(idx,wArraySize,w):h}>{w.display()}</li>
  {end:}
</ul>
