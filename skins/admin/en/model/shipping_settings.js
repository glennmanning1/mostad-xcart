/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Shipping settings controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'additionalSettings',
  'h2#additionalsettingsseparator',
  function () {
    jQuery(this).bind('click', function () {
      jQuery(this).toggleClass('expanded').closest('li').nextAll().toggle();
    });

    jQuery(this).closest('li').nextAll().hide();
  }
);
