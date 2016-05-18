{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price value
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="product.plain_price", weight="10")
 * @ListChild (list="product.plain_price_only", weight="10")
 *}

{if:hasWholesalePriceClass()}
<li><span>This has volume pricing for it's category, see price in cart.</span></li>
{else:}
<li>
    <span class="price product-price">{formatPrice(getListPrice(),null,1):h}</span>
    <span class="uom product-uom">{getUOM()}</span>
</li>
{end:}
