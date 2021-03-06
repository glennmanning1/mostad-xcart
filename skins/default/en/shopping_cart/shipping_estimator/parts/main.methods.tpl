{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping estimator : methods
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="shippingEstimator.main", weight="20")
 *}
<div IF="isEstimate()" class="estimate-methods">
  <div class="head-h3">{t(#Choose shipping method#)}</div>
  <widget class="XLite\View\Form\Cart\ShippingEstimator\Change" name="change" className="method-change" />

    {if:hasRates()}
      <widget class="XLite\View\ShippingList" />

      <div class="buttons main">
        <widget class="XLite\View\Button\Submit" label="Save" />
      </div>
    {else:}
      <p class="error">{t(#Shipping methods are not available#)}</p>
    {end:}

  <widget name="change" end />
</div>
