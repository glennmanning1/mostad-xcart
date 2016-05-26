{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list item : spec : number
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.children.spec", weight="200")
 *}
<li class="order-number"><a href="{buildURL(#order#,##,_ARRAY_(#order_number#^order.getOrderNumber()))}">#{order.getOrderNumber()}</a></li>