{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Wholesale prices table
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="wholesale.price", weight="20")
 *}

<table class="wholesale-prices-product-block">

    <tr>
        <td  FOREACH="getWholesalePrices(),wholesalePrice" >
            {wholesalePrice.getQuantityRangeBegin()}{if:wholesalePrice.getQuantityRangeEnd() = 0} - {wholesalePrice.getQuantityRangeEnd()}{else:}+{end:}
        </td>
    </tr>
    <tr>
        <td  FOREACH="getWholesalePrices(),wholesalePrice" >
            {formatPrice(wholesalePrice.getDisplayPrice(),null,1):h}
        </td>
    </tr>
</table>
