/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Banner rotation: customer zone controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'BannerRotation',
  '#banner-rotation-widget',
  function (event) {
    var $this = jQuery(this);
    var options = core.getCommentedData(this);
    $this.carousel(options);
    $this.carousel('cycle');

    var firstItem = $this.find('.item').first();
    firstItem.addClass('active');

    var firstIndicator = $this.find('.carousel-indicators li').first();
    firstIndicator.addClass('active');

    var maxHeight = firstItem.find('img').height();
    if (maxHeight > 0) {
      firstItem.find('img').onload = function () {
        jQuery('#banner-rotation-widget .carousel-inner').height(maxHeight);
      };

      jQuery('#banner-rotation-widget .carousel-inner').height(maxHeight);
    }
  }
);
