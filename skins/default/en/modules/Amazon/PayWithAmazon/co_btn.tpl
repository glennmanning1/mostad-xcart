{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="checkout.shipping.selected.sub.payment", weight="2000")
*}
{if:isPayWithAmazonActive()}
<div style="padding-left: 57px;">
  <div id="payWithAmazonDiv_co_btn">
	  <img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
  </div>
</div>
{end:}
