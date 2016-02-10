/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Check for update button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */


function CheckForUpdatesButton()
{
  CheckForUpdatesButton.superclass.constructor.apply(this, arguments);
}

// New POPUP button widget extends POPUP button class
extend(CheckForUpdatesButton, ProgressStateButton);

CheckForUpdatesButton.autoload = function () {
  jQuery('.btn.check-for-updates').each(
    function () {
      if (!this.checkForUpdates) {
        var checkForUpdates = new CheckForUpdatesButton(this);

        this.checkForUpdates = checkForUpdates;

        jQuery(this).click(function () {
          checkForUpdates.clearCache();
        });
      };
    }
  );
};

CheckForUpdatesButton.prototype.clearCache = function() {
  var obj = this;
  core.get(
    URLHandler.buildURL({
      'target': 'addons_list_marketplace',
      'action': 'clear_cache'
    }),
    function(xhr, status, data) {
      obj.setStateSuccess();
      self.location.reload(true);
    }
  );
};

core.autoload(CheckForUpdatesButton);

core.microhandlers.add(
  'CheckForUpdatesButton',
  '.btn.check-for-updates',
  function (event) {
    core.autoload(CheckForUpdatesButton);
  }
);
