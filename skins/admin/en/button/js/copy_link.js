/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Copy link button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    var clipboard = new Clipboard('button.copy-link');
    clipboard.on('success', function(e) {
      core.trigger('message', {type: 'info', message: core.t('The link was copied to your clipboard')});
    });
  }
);
