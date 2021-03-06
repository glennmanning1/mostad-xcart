/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Login link
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(
  function() {

    // Open login link is popup
    core.microhandlers.add(
      'loginPopup',
      'a.log-in',
      function() {
        jQuery(this).click(
          function(event) {
            loadDialogByLink(
              event.currentTarget,
              URLHandler.buildURL({
                'target':  'login',
                'widget':  '\\XLite\\View\\Authorization',
                'popup':   1,
                'fromURL': (self.location + ''),
                'login':   jQuery(event.currentTarget).data('login') ? jQuery(event.currentTarget).data('login') : ''
              }),
              {width: 'auto'},
              null,
              this
            );

            return false;
          }
        )
      }
    );

    // Login popup form
    core.microhandlers.add(
      'loginPopupForm',
      'form.login-form',
      function(event) {
        if (jQuery(this).parents('.popup-window-entry').length) {

          this.commonController.enableBackgroundSubmit();
          var form = this.commonController.$form;

          form.find('a.forgot').click(
            function(event) {
              loadDialogByLink(
                event.currentTarget,
                URLHandler.buildURL({
                  'target':  'recover_password',
                  'widget':  '\\XLite\\View\\RecoverPassword',
                  'popup':   1,
                  'fromURL': (self.location + ''),
                  'email':   form.find('#login').val() ? form.find('#login').val() : ''
                }),
                {width: 'auto'},
                null,
                this
              );

              return false;
            }
          );

          var f = this.commonController.getErrorPlace;
          this.commonController.getErrorPlace = function()
          {
            if (!this.errorPlace) {
              var box = f.apply(this);
              box
                .remove()
                .insertBefore(this.$form.find('button[type="submit"]').eq(0));
            }

            return this.errorPlace;
          }

          core.bind(
            'recoverPasswordSent',
            function() {
              popup.close();
            }
          );
        }
      }
    );

    // Recovery password popup form
    core.microhandlers.add(
      'recoverPasswordPopupForm',
      'form.recovery-form',
      function(event) {
        if (jQuery(this).parents('.popup-window-entry').length) {
          this.commonController.enableBackgroundSubmit();
        }
      }
    );
  }
);

