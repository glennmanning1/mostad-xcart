{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.panel.totals", weight="1000")
*}
{if:isPayWithAmazonActive()}
<li class="button">
  <div id="payWithAmazonDiv_cart_btn">
	  <img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
  </div>
</li>
{end:}
