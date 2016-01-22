/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Trial notice button and popup controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonCredentialsForm()
{
  PopupButtonCredentialsForm.superclass.constructor.apply(this, arguments);
  console.log('heyhey');
}

// New POPUP button widget extends POPUP button class
extend(PopupButtonCredentialsForm, PopupButton);

// New pattern is defined
PopupButtonCredentialsForm.prototype.pattern = '.pb-credentials-form';

PopupButtonCredentialsForm.prototype.enableBackgroundSubmit = false;

decorate(
  'PopupButtonCredentialsForm',
  'callback',
  function(selector) {
  }
);

// Autoloading new POPUP widget
core.autoload(PopupButtonCredentialsForm);