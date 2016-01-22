/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add payment method JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonAddShippingMethod()
{
  PopupButtonAddShippingMethod.superclass.constructor.apply(this, arguments);
}

extend(PopupButtonAddShippingMethod, PopupButton);

PopupButtonAddShippingMethod.prototype.pattern = '.add-shipping-method-button';

decorate(
  'PopupButtonAddShippingMethod',
  'eachClick',
  function (elem)
  {
    if (!elem.linkedDialog && jQuery('.ajax-container-loadable.widget-shipping-addmethod').length) {
      jQuery('.ajax-container-loadable.widget-shipping-addmethod').closest('.ui-widget-content').remove();
    }

    arguments.callee.previousMethod.apply(this, arguments);
  }
);

decorate(
  'PopupButtonAddShippingMethod',
  'callback',
  function ()
  {
    $('.add-shipping .tab:first a').tab('show');
    core.microhandlers.add(
      'ItemsListMarkups',
      '.offline-shipping-create',
      function () {
        core.autoload(TableItemsListQueue);
      }
    )
  }
);

core.autoload(PopupButtonAddShippingMethod);
