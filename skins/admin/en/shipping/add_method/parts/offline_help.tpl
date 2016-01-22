{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Help for offline carrier form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="offline-help">
  <div class="help-header">
    {t(#Here you can provide general information about the shipping method and configure a table defining how shipping rates for this method should be calculated.#)}

    <span class="help-link">{t(#How to define shipping rates#)}</span>
  </div>

  <div class="help-content">
         {t(#You can set up different shipping rates depending on the weight, price or quantity of items in the order.#)}
    <br/>
    <br/>{t(#Shipping rates are calculated by the following formula:#)}
    <br/>{t(#SHIPPING = flat + ITEMS*per_item + SUBTOTAL*(% of subtotal)/100 + WEIGHT*per_weight;#,_ARRAY_(#X#^config.Units.weight_unit))}
    <br/>
    <br/>{t(#You can define the following values:#)}
    <br/><strong>{t(#flat rate#)}</strong>
    - {t(#Flat shipping charge. This value will be added to the shipping rate regardless of the weight, price and number of items ordered.#)}
    <br/><strong>{t(#per item#)}</strong>
    - {t(#Flat shipping charge per item ordered.#)}
    <br/><strong>{t(#%#)}</strong>
    - {t(#Shipping charge based on a percentage of the order subtotal.#)}
    <br/><strong>{t(#per weight unit#)}</strong>
    - {t(#Flat shipping charge per weight unit ordered (for example, per pound or per kilogram - depending on the weight units used by your store).#)}
    </div>
</div>
