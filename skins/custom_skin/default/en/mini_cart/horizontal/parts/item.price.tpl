{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Display horizontal minicart item price
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="minicart.horizontal.item", weight="20")
 *}
<div class="item-price">
    <table>
        <tr>
            <td align="left">
                <span class="quantity">{item.getAmount()} {item.getUomDisplay()}</span>
                {if:!item.hasWholesalePriceClass()}
                &times; <widget class="XLite\View\Surcharge" surcharge="{item.getDisplayPrice()}" currency="{cart.getCurrency()}" />
                {end:}
            </td>
            <td align="right">
                {if:item.hasWholesalePriceClass()}
                See below
                {else:}
                <widget class="XLite\View\Surcharge" surcharge="{item.getSubtotal()}" currency="{cart.getCurrency()}" />
                {end:}
            </td>
        </tr>
    </table>
</div>
