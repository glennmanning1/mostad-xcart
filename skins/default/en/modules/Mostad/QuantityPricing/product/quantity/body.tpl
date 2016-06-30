{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product quantity widget (for customer area)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<span class="{getCSSClass()} {getFingerprint()}">
{if:!isOutOfStock()}
  {t(#Qty#)}: <widget class="\XLite\View\Product\QuantityBox" fieldValue="{getQuantity()}" product="{getProduct()}" maxValue="{getMaxQuantity()}" productVariant="{getProductVariant()}" />
{end:}
</span>