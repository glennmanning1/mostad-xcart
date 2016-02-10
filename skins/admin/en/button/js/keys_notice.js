/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * License warning button and popup controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonKeysNotice()
{
  PopupButtonKeysNotice.superclass.constructor.apply(this, arguments);
}

// New POPUP button widget extends POPUP button class
extend(PopupButtonKeysNotice, PopupButton);

// New pattern is defined
PopupButtonKeysNotice.prototype.forcePattern = '.keys-notice.force-notice';
PopupButtonKeysNotice.prototype.pattern = '.keys-notice';

PopupButtonKeysNotice.prototype.enableBackgroundSubmit = false;

PopupButtonKeysNotice.prototype.callback = function (selector, link)
{
  PopupButton.prototype.callback.apply(this, arguments);
  jQuery('form', selector).each(
    function() {
      this.commonController.backgroundSubmit = false;
    }
  );
};

// Autoloading new POPUP widget
core.autoload(PopupButtonKeysNotice);

// Auto display popup window
jQuery(document).ready(function () {
  if (jQuery(PopupButtonKeysNotice.prototype.forcePattern))
    jQuery(PopupButtonKeysNotice.prototype.forcePattern).click();
});
