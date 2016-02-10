{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Name item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="packing_slip.item", weight="20")
 *}
<td class="item">
  <a IF="item.getURL()" href="{item.getURL()}" class="item-name">{item.getName()}</a>
  <span IF="!item.getURL()" class="item-name">{item.getName()}</span>
  <span IF="!item.product.isPersistent()" class="deleted-product-note">({t(#deleted#)})</span>

  <div class="item-options">
    <ul IF="isViewListVisible(#packing_slip.item.name#,_ARRAY_(#item#^item))" class="subitem additional simple-list">
      <list name="packing_slip.item.name" item="{item}" />
    </ul>
    <ul IF="isAttributesVisible(item)" class="subitem attributes simple-list">
      <li>{t(#Options:#)}&nbsp;</li>
      <li foreach="item.getAttributeValues(),av" class="attribute">
        {av.value}
      </li>
    </ul>
  </div>
</td>
