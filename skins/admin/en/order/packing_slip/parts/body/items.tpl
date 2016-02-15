{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice items
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="packing_slip.base", weight="30")
 *}
<table cellspacing="0" class="items">
  <tr><list name="packing_slip.items.head" /></tr>
  {foreach:orderItems,index,item}
  <tr><list name="packing_slip.item" item="{item}" /></tr>
  {end:}
  <tr FOREACH="getViewList(#packing_slip.items#),w">{w.display()}</tr>
</table>