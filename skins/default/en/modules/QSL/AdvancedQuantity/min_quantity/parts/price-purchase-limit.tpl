{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Minimum quantity widget
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="wholesale.minquantity", weight="10")
 *}

 <div class="wholesale-minimum-quantity-wrapper">
   <span class="wholesale-minimum-quantity">
     <span class="label">{t(#Minimum purchase quantity#)}:</span>
     {foreach:getMinimumOrderQuantityList(),qty}
       <span class="unit-count">{qty.qty} {qty.unit}</span>
       <span IF="isOrVisible(qty,qtyArrayPointer,qtyArraySize)" class="unit-count-or">{t(#or#)}</span>
     {end:}
   </span>
 </div>
