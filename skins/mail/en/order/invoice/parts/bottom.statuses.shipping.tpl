{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice shipping status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.address.shipping", weight="30")
 *}
<div class="shipping-status" IF="order.getShippingStatus()" style="font-size: 15px;margin-top:15px">
  <strong style="color: #000;font-size: 20px;padding-bottom: 6px;display: block;font-weight: normal;">{t(#Shipping status#)}:</strong>
  {order.shippingStatus.getCustomerName():h}
</div>
