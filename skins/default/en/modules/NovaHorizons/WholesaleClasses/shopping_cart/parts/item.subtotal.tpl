{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart item : subtotal
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="cart.item", weight="60")
 *}
<td class="item-subtotal">
    {if:item.hasWholesalePriceClass()}
    See volume pricing
    {else:}
  <span class="subtotal{if:item.getExcludeSurcharges()} modified-subtotal{end:}"><widget class="XLite\View\Surcharge" surcharge="{item.getDisplayTotal()}" currency="{cart.getCurrency()}" /></span>
  <div IF="item.getExcludeSurcharges()" class="including-modifiers" style="display: none;">
    <table class="including-modifiers" cellspacing="0">
      <tr FOREACH="item.getExcludeSurcharges(),surcharge">
        <td class="name">{t(#Including X#,_ARRAY_(#name#^surcharge.getName()))}:</td>
        <td class="value"><widget class="XLite\View\Surcharge" surcharge="{surcharge.getValue()}" currency="{cart.getCurrency()}" /></td>
      </tr>
    </table>
  </div>
    {end:}
  <list name="cart.item.actions" item="{item}" />
</td>
