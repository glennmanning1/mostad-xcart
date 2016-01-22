{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pitney Bowes shipping label
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="shipping-label">
	<p>To: {getRecipient()}</p>
	<p class="address">{getDestination():h}</p>
	<p class="phone">{getPhone():h}</p>
	<p class="order">Order number: <span class="order-number">{getOrderNumber()}</span></p>
	<div class="barcode">
		<img src="{getBarcodeURL()}">
		<p class="text">{getBarcodeText()}</p>
	</div>
</div>
