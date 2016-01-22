/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Print invoice button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

// This function opens popup window 'Print label' and print its content
function openPrintLabel (elem) {
  var params = core.getCommentedData(elem, 'url_params')
  var url = URLHandler.buildURL(params);

  jQuery(elem).addClass('suspended');

  if (jQuery('#iframe-label').length) {
    jQuery('#iframe-label').remove();
  }
  jQuery("<iframe id='iframe-label' name='label' style='height: 0px; width: 0px;' src='" + url + "' />").appendTo('body');
  jQuery('#iframe-label').load(
    function() {
      jQuery(elem).removeClass('suspended');
      window.frames['label'].focus();
      window.frames['label'].print();
    }
  );
}
