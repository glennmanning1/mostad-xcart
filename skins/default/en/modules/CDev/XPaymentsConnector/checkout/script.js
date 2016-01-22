/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * X-Payments iframe and checkout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/**
 * IFRAME actions
 */
var XPC_IFRAME_DO_NOTHING       = 0;
var XPC_IFRAME_CHANGE_METHOD    = 1;
var XPC_IFRAME_CLEAR_INIT_DATA  = 2;
var XPC_IFRAME_ALERT            = 3;
var XPC_IFRAME_TOP_MESSAGE      = 4;


decorate(
  'CheckoutView',
  'postprocess',
  function(isSuccess, initial)
  {
    arguments.callee.previousMethod.apply(this, arguments);

    if (isSuccess) {
      jQuery(window).bind('message', _.bind(this.messageListener, this));

      jQuery('form.place').submit(
        _.bind(
          function() {

            var formData = {
              notes : $('#place_order_note').val(),
              save_card : $('#save-card').is(':checked') ? 'Y' : 'N'
            };

            $.post('cart.php?target=checkout&action=save_checkout_form_data', formData);

            if (jQuery('.xpc_iframe').length && !this.base.find('form.place').hasClass('allowed')) {
              var message = {
                message: 'submitPaymentForm',
                params:  {}
              };

              var xpcShown = jQuery('.xpc_iframe').get(0);

              if (window.postMessage && window.JSON) {
                xpcShown.contentWindow.postMessage(JSON.stringify(message), '*');
              }

              return false;
            }
          },
          this
        )
      );
    }
  }
);

CheckoutView.prototype.messageListener = function (event)
{
  var msg = getXpcIframeEventDataObject(event);

  if (!checkXpcIframeMessage(msg)) {
    return;
  }

  if ('paymentFormSubmit' == msg.message) {
    jQuery('.place-order').click();
    return;
  }

  if (msg.params.height) {
    jQuery("#xpc").css('height', msg.params.height);
  }

  var type = parseInt(msg.params.type);
  var message = msg.params.error;

  if (
    message 
    && XPC_IFRAME_DO_NOTHING != type
  ) {

    if (XPC_IFRAME_TOP_MESSAGE == type) {

      core.trigger('message', { 'message': message, 'type': MESSAGE_ERROR });

    } else {

      if (
        XPC_IFRAME_CHANGE_METHOD == type
        || XPC_IFRAME_CLEAR_INIT_DATA == type
        || XPC_IFRAME_ALERT == type
      ) {
        xpcPopupError = true;
        $('.xpc-box').hide();
      }

      var url = URLHandler.buildURL({ 'target': 'xpc_popup', 'type': type, 'message': escape(message) }); 

      popup.load(url);

      this.triggerVent('xpc.error', { 'widget': this, 'error': message, 'type': type });
    }
  }

  if (msg.params.returnURL) {

    this.base.find('form.place').addClass('allowed').get(0).setAttribute('action', msg.params.returnURL);
    this.base.find('form.place input[name="action"]').val('return');
    this.base.find('.place-order').removeClass('disabled').removeClass('submitted').click().addClass('submitted');

    this.triggerVent('xpc.redirect', {widget: this});

    // Doesn't seem to be a best or supposed way
    // However, it INDEED submits the form
    $('form.place').submit();

  } else {

    xpcLoading = false;
    xpcShadeFlag = false;
    jQuery('.save-card-box').show();
    jQuery(xpcAllWidget).get(0).loadable.unshade();
    jQuery(xpcSmallWidget).get(0).loadable.unshade();
    core.trigger('checkout.common.anyChange');

    this.triggerVent('xpc.unshade', {widget: this});

    this.base.find('.place-order').removeClass('submitted');
  }
}

var xpcSmallWidget = '.cart-items';
var xpcWrongWidget = '.payment-tpl';
var xpcAllWidget = '.steps';

var xpcLoading = false;
var xpcShadeFlag = false;

var xpcPopupError = false;

core.bind(
  'load',
  function() {

    decorate(
      'CartItemsView',
      'unshade',
      function(isSuccess, initial) {
        if (!xpcLoading) {
          arguments.callee.previousMethod.apply(this, arguments);
        }
      }
    );

    decorate(
      'CartItemsView',
      'switchCards',
      function (isSuccess, initial) {
        jQuery('.saved-cards').children().each(
          function () {
            jQuery(this).removeClass('hidden');
          }
        );
        jQuery('.saved-cards').removeClass('single');
        jQuery('.switch-cards-link').hide();
      }
    );

    if (typeof(xpcPaymentIds) !== "undefined" && xpcPaymentIds[currentPaymentId]) {
      jQuery('.bright').addClass('disabled');
    }

    core.bind(
      'checkout.cartItems.postprocess',
      function(event, data) {
        if (typeof(xpcPaymentIds) !== "undefined" && xpcPaymentIds[currentPaymentId]) {

          if (jQuery('.xpc_iframe').length) {
            xpcLoading = true;
          }

          if (jQuery('.save-card-box').length) {
            jQuery('.save-card-box').hide();

          } else {
            jQuery('.bright').addClass('disabled');
          }
        }
      }
    );

    core.bind(
      'checkout.cartItems.shaded',
      function(event, data) {
        xpcShadeFlag = true;
      }
    );

    core.bind(
      'checkout.cartItems.unshaded',
      function(event, data) {
        xpcShadeFlag = false;
      }
    );

    core.bind(
      'checkout.paymentTpl.shade',
      function(event, state) {
        if (state.result && jQuery(xpcSmallWidget).get(0).loadable.isShowModalScreen) {
          state.result = false;
        }
      }
    );

    core.bind(
      'checkout.paymentTpl.postprocess',
      reloadXpcIframe
    );

    core.bind(
      'checkout.common.state.nonready',
      function(event, state) {
        jQuery('.xpc-box').hide();
      }
    );

    core.bind(
      'checkout.common.state.blocked',
      function(event, state) {

        if (!xpcPopupError) {
          jQuery('.xpc-box').show();
        }
      }
    );

    core.bind(
      'checkout.common.state.ready',
      function(event, state) {
        jQuery('.xpc-box').show();
      }
    );

    core.bind(
      'xpcevent',
      function(event, data) {

        // Process "Use saved card" box
        if (data.showSaveCardBox == 'Y') {
          jQuery('.save-card-box').show();
          jQuery('.save-card-box-no-iframe').show();
        } else {
          jQuery('.save-card-box').hide();
          jQuery('.save-card-box-no-iframe').hide();
        }

        // Process payment template box
        if (data.checkCheckoutAction == 'Y') {
          jQuery('.xpc-box').show();
          reloadXpcIframe();
        } else {
          jQuery('.xpc').hide();
        }


      }
    );

    core.bind(
      'updateCart',
      function(event, data) {

        xpcLoading = false;

        if (
          data.shippingMethodId
          || data.shippingAddressId
          || data.billingAddressId
          || data.total
        ) {

          var iframe = jQuery('.xpc_iframe');

          if (iframe.length) {
            xpcLoading = true;
            jQuery('.save-card-box').hide();
            jQuery(xpcSmallWidget).get(0).loadable.shade();
            reloadXpcIframe(event, data);
          }

        } else if (
          data.paymentMethodId
          && xpcPaymentIds
          && xpcPaymentIds[data.paymentMethodId]
        ) {
          xpcLoading = true;
          jQuery('.save-card-box').hide();
          jQuery(xpcSmallWidget).get(0).loadable.shade();
        }
      }
    );

    core.bind(
      'popup.close',
      function(event, state) {

        if (
          $('.xpc-popup button')
          && xpcPopupError
        ) {
          $('.xpc-popup button').click();
        }
      }
    );

  }
);

function reloadXpcIframe(event, data)
{
  var iframe = $('.xpc_iframe');

  var src = iframe.attr('src');

  if (!src) {
    src = iframe.data('src');
  }

  iframe.attr('src', src);
}
