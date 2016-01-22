/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add payment method JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(function($) {
    core.bind(
      'list.model.table.line.new.add',
      function() {
        $('.sticky-panel .save button.submit').removeClass('disabled');
        $('.sticky-panel .save button.submit').prop('disabled', false);
        $('.pb-parcels button.create-inline').prop('disabled', true);
      }
    );
});
