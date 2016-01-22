/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Shipping carriers controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
function ShippingCarriersList()
{
  ShippingCarriersList.superclass.constructor.apply(this, arguments);

  var self = this;
  core.bind('updateshippingmethods', function () { self.load(); });
}

extend(ShippingCarriersList, ALoadable);

ShippingCarriersList.autoload = function()
{
  jQuery('.items-list.shipping-carriers').closest('.dialog-content').each(
    function() {
      new ShippingCarriersList(this);
    }
  );
};

ShippingCarriersList.initialRequested = false;

ShippingCarriersList.prototype.shadeWidget = true;

ShippingCarriersList.prototype.widgetTarget = 'shipping_methods';

ShippingCarriersList.prototype.widgetClass = 'XLite\\View\\ItemsList\\Model\\Shipping\\Carriers';

ShippingCarriersList.prototype.postprocess = function(isSuccess) {
  ALoadable.prototype.postprocess.apply(this, arguments);

  if (isSuccess) {
    core.autoload(PopupButtonEditShippingMethod);
    core.autoload(PopupButtonAddShippingMethod);
    core.autoload(TableItemsListQueue);
  }
};

core.autoload(ShippingCarriersList);
