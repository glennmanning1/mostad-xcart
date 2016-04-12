/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Quantity controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.registerWidgetsParamsGetter(
  'update-product-page',
  function (product)
  {
    var value = jQuery(".product-qty :input.quantity").val();
    var quantity = 1;
    var unit = '';
    if (value.search(/\|/) != -1) {
      var parts = value.split(/\|/);
      quantity = parts[0];
      unit = parts[1];

    } else if (jQuery(".product-qty :input.quantity-unit").length) {
      var unitSelector = jQuery(".product-qty :input.quantity-unit");
      quantity = value * jQuery(unitSelector.get(0).options[unitSelector.get(0).selectedIndex]).data('multiplier');
      unit = unitSelector.val();
    }

    return {
      quantity: quantity,
      unit:     unit
    };
  }
);
core.registerWidgetsTriggers(
  'update-product-page',
  function ()
  {
    return '.product-qty :input.quantity,.product-qty select.quantity-unit';
  }
);
core.registerTriggersBind(
  'update-product-page',
  function ()
  {
    jQuery('.product-qty select.quantity,.product-qty select.quantity-unit').change(
      function() {
        core.trigger('update-product-page', jQuery('form.product-details input[name="product_id"]').val());
      }
    );
  }
);
core.registerShadowWidgets(
  'update-product-page',
  function()
  {
    return '.product-qty :input.quantity,.product-qty select.quantity-unit';
  }
);
