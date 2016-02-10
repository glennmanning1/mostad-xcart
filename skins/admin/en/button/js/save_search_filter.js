/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * 'Save search filter' button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    jQuery('div.save-search-filter .button-label').click(
      function () {
        //jQuery(this).hide();
        var boxAction = jQuery(this).parent().find('.button-action').eq(0);
        if (0 < boxAction.length) {
          var visibility = 'visible';
          if (visibility == jQuery(boxAction).css('visibility')) {
            visibility = 'hidden';
          }
          jQuery(boxAction).css('visibility', visibility);
        }
      }
    );
  }
);
