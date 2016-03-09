{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price value
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.plain_price", weight="10")
 * @ListChild (list="product.plain_price_only", weight="10")
 *}

{if:hasWholesalePriceClass()}
    <li><span>This has Volume pricing for it's category, see price in cart.</span></li>
{else:}
<li><span class="price product-price">{formatPrice(getListPrice(),null,1):h}</span></li>
{end:}
