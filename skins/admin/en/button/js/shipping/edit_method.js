/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add payment method JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonEditShippingMethod()
{
  PopupButtonEditShippingMethod.superclass.constructor.apply(this, arguments);

  core.bind('list.model.table.initialize', function(){
    core.autoload(PopupButtonEditShippingMethod);
  });
}

extend(PopupButtonEditShippingMethod, PopupButton);

PopupButtonEditShippingMethod.prototype.pattern = '.edit-shipping-method-button';

decorate(
    'PopupButtonEditShippingMethod',
    'eachClick',
    function (elem)
    {
      if (jQuery('.ajax-container-loadable.widget-shipping-editmethod').length) {
        jQuery('.ajax-container-loadable.widget-shipping-editmethod').closest('.ui-widget-content').remove();
      }

      jQuery(elem).toggleClass('always-reload', elem.linkedDialog && jQuery(elem.linkedDialog).length === 0);

      arguments.callee.previousMethod.apply(this, arguments);
    }
);

decorate(
  'PopupButtonEditShippingMethod',
  'callback',
  function ()
  {
    core.microhandlers.add(
      'ItemsListMarkups',
      '.offline-shipping-create',
      function () {
        core.autoload(TableItemsListQueue);
      }
    )
  }
);

core.autoload(PopupButtonEditShippingMethod);
