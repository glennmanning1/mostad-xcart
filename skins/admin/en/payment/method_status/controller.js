/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PaymentMethodSwitcher () {
  jQuery('#payment-method-status').change(function (event)
  {
    event.stopImmediatePropagation();

    var switchWrapper = jQuery('.payment-status');
    if (switchWrapper.length) {
      assignShadeOverlay(switchWrapper);
    }

    var method = switchWrapper.data('method');

    core.get(
      URLHandler.buildURL({
        target: 'payment_settings',
        action: 'switch',
        id: method
      }),
      function () {
        if (switchWrapper) {
          unassignShadeOverlay(switchWrapper);
          switchWrapper.find('.alert').toggleClass('alert-success').toggleClass('alert-warning');
        }
      }
    );

    return false;
  });
}

core.autoload(PaymentMethodSwitcher);