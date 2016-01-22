{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 * @ListChild (list="add2cart_popup.item", weight="1000")
 *}
{if:isPayWithAmazonActive()}
<div id="payWithAmazonDiv_add2c_popup_btn" style="padding:8px 0 0 200px;">
	<img src="{getAmazonButtonURL()}" style="cursor: pointer;" />
</div>
{end:}
