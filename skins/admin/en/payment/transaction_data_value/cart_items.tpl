{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order items summary
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<table cellspacing="0" class="cart-items-summary">

    {foreach:getValue(),item}
        <tr>
            <td class="name-column">
                <p class="name">{item.name}</p>
                <p class="sku">SKU {item.sku}</p>
                <img src="images/spacer.gif" class="right-fade" alt="" />
            </td>
            <td IF="item.attrs" class="attr-column">
                <ul class="attributes">
                    <li FOREACH="item.attrs,attr">{attr.name}: {attr.value}</li>
                </ul>
                <img src="images/spacer.gif" class="right-fade" alt="" />
            </td>
            <td class="price-column">
                <p><span class="price">{formatPrice(item.price)}</span> × <span class="qty">{item.amount}</span></p>
            </td>
        </tr>
    {end:}

</table>
