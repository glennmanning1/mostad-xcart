{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Price item cell
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="invoice.item", weight="20")
 *}
<td class="price">{if:!item.hasWholesalePriceClass()}{formatInvoicePrice(item.getItemNetPrice(),order.getCurrency(),1)}{end:}</td>
