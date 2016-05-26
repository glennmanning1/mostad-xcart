{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : included surcharges
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="300")
 *}

{if:order.getItemsIncludeSurchargesTotals()}  
  <li class='included-surcharge' FOREACH="order.getItemsIncludeSurchargesTotals(),row">
    <div class="title">{t(#Including X#,_ARRAY_(#name#^row.surcharge.getName()))}:</div>
    <div class="value">{formatPrice(row.cost,order.getCurrency())}</div>
  </li>
{end:}
