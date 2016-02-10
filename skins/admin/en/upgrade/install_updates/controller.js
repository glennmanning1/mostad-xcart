/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var toogleChecked = function (value) {
  jQuery('.update-module-list input[type=checkbox]').attr('checked', value || false);
}

core.microhandlers.add(
  'Uncheck all updates',
  '.uncheck-all',
  function (event) {
    jQuery(this).click(function(event) {
      toogleChecked(false);
    });
  }
);

core.microhandlers.add(
  'Check all updates',
  '.check-all',
  function (event) {
    jQuery(this).click(function(event) {
      toogleChecked(true);
    });
  }
);
