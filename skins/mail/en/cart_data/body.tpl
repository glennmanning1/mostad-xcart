{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order invoice
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<table width="80%" style="font-family: Helvetica, Arial, sans-serif;">
    <tr>
        <td>
            <widget template="order/invoice/parts/items.tpl"/>
            <widget template="order/invoice/parts/totals.tpl"/>
            <widget template="cart_data/parts/bottom.tpl"/>
            <widget template="order/invoice/parts/note.tpl"/>
            <widget template="order/invoice/parts/footer.tpl"/>
        </td>
    </tr>
</table>
