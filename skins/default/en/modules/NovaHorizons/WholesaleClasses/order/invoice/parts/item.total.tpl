{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Total item cell
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="invoice.item", weight="30")
 *}
<td class="total">{if:item.hasWholesalePriceClass()}See below{else:}{formatInvoicePrice(item.getDisplayTotal(),order.getCurrency(),1)}{end:}</td>
