/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'MarketplaceSearch',
  '.marketplace-search',
  function (event) {
    jQuery(this).click(function() {
      jQuery.ajax({
        async: false,
        type: 'GET',
        url: URLHandler.buildURL({
          target:         'addons_list_marketplace',
          clearCnd:       '1',
          clearSearch:    '1'
        }),
        data: ''
      });
    });
  }
);