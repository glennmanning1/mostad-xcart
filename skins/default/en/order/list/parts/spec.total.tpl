{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list item : spec : total
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.children.spec", weight="500")
 *}
<li class="order-total"><span class="order-spec-label total-label">{t(#Total#)}:</span><span class="order-spec-value total-value">{formatOrderPrice(order.getTotal(),order.getCurrency(),1)}</span></li>
