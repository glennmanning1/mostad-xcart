{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list item : spec : items count
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.children.spec", weight="600")
 *}
<li class="order-items-count"><span class="order-spec-label order-items-count-label">{t(#Items#)}:</span><span class="order-spec-value order-items-count-value">{order.countQuantity()}</span></li>
