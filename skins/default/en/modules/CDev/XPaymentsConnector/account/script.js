/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Sale widget controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

$(document).ready(function() {

  $('#submit-button').click(function() {

    var message = {
      message: 'submitPaymentForm',
      params:  {}
    };

    var iframe = jQuery('#add_new_card_iframe').get(0);

    if (window.postMessage && window.JSON) {
      iframe.contentWindow.postMessage(JSON.stringify(message), '*');
    }
  });

  $(window).on('message', function(event) {

    var msg = getXpcIframeEventDataObject(event);

    if (!checkXpcIframeMessage(msg)) {
      return;
    }

    if (
      msg
      && msg.params
      && msg.params.error
      && XPC_IFRAME_TOP_MESSAGE == parseInt(msg.params.type)
    ) {
      console.log('error');
      core.trigger('message', { 'message': msg.params.error, 'type': MESSAGE_ERROR });
    }

  });

});
