/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * create backup controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function EmailLinksButton () {
  this.button = jQuery('button.email-links');

  var self = this;
  this.button.click(function () {
    self.sendRequest();
  })
}

EmailLinksButton.prototype.sendRequest = function () {
  var params = {
      target: 'safe_mode',
      action: 'email_links',
  };
  params[xliteConfig.form_id_name] = xliteConfig.form_id;
  core.post(
    {
      target: 'safe_mode',
      action: 'email_links',
    },
    _.bind(this.success, this),
    params
  );
};

EmailLinksButton.prototype.success = function () {
  this.button.get(0).progressState.clearState();
  this.button.get(0).progressState.setStateStill();
  this.button.get(0).progressState.setLabel('Email again');
};

core.autoload(EmailLinksButton);
