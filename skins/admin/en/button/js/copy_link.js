/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Print invoice button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    var clip = new ZeroClipboard(
      jQuery('button.copy-link'),
      {
        moviePath: xliteConfig.zeroClipboardSWFURL
      }
    );

    clip.on('complete', function (client, args) {
      core.trigger('message', {type: 'info', message: core.t('The link was copied to your clipboard')});
    });
  }
);
