{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart item : price
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="cart.item", weight="40")
 *}

<td class="item-price">{if:!item.hasWholesalePriceClass()}<widget class="XLite\View\Surcharge" surcharge="{item.getDisplayPrice()}" currency="{cart.getCurrency()}" />{end:}</td>

<td class="item-multi">&times;</td>
