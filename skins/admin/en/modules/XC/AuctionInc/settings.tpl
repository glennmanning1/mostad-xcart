{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * AuctionInc settings
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div IF="isXSAvailable()">
  {t(#30 Day Trial of AuctionInc ShippingCalc Module. Days Left: X#,_ARRAY_(#days#^getXSDays())):h}
</div>

<div IF="isXSExpired()">
  {t(#30 Day Trial of AuctionInc ShippingCalc Module is over#):h}
</div>

<widget class="XLite\Module\XC\AuctionInc\View\Model\Settings" />
