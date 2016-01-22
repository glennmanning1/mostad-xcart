/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Place order controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function createASNCall (elem) {

  var params = core.getCommentedData(elem, 'url_params');
  elem.disable();
  core.post(
    URLHandler.buildURL(params),
    null,
    {},
      {
        timeout: 600000,
        success: function (xhr, textStatus) {
          core.trigger('message', {type: 'info', message: core.t('Advanced shipment notification has been sent to PitneyBowes')});

          var progressState = new ProgressStateButton(elem);
          progressState.setStateSuccess();
        },
        error: function (xhr, textStatus, errorThrown) {
        }
   }
  );
}