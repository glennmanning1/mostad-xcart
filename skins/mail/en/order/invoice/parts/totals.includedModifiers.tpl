{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="300")
 *}
{if:order.getItemsIncludeSurchargesTotals()}  
    <li FOREACH="order.getItemsIncludeSurchargesTotals(),sType,surcharge" style="list-style: none;padding: 0px;margin: 0px;color: #5a5a5a;">
        <div style="display: inline;color: #5a5a5a;">{t(#Including X#,_ARRAY_(#name#^surcharge.surcharge.getName()))}:</div>
        <div style="display: inline;color: #5a5a5a;padding-left: 6px;">{formatSurcharge(surcharge)}</div>
    </li>
{end:}
