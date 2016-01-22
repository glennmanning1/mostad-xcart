{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Markup formula example
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<span class="formula">
  {t(#shippingFormula.Shipping#)} =

  <span class="flat-rate"><span class="part-value"></span> <span class="plus">+</span></span>
  <span class="items">{t(#shippingFormula.Items#)} * <span class="part-value"></span> <span class="plus">+</span></span>
  <span class="subtotal">{t(#shippingFormula.Subtotal#)} * <span class="part-value"></span>% <span class="plus">+</span></span>
  <span class="weight">{t(#shippingFormula.Weight#)} * <span class="part-value"></span></span>
  <span class="free">{t(#shippingFormula.Free#)}</span>
</span>

