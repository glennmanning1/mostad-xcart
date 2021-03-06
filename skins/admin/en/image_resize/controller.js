/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Import / export controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function() {
    jQuery('.resize-progress .bar')
      .bind(
        'changePercent',
        function(event, data) {
          if (data && 'undefined' != typeof(data.timeLabel)) {
            jQuery('.resize-progress .time').html(data.timeLabel);
          }
        }
      )
      .bind(
        'error',
        function() {
          this.errorState = true;
          self.location = URLHandler.buildURL({ 'target': 'images', 'resize_failed': 1 });
        }
      )
      .bind(
        'complete',
        function() {
          if (!this.errorState) {
            self.location = URLHandler.buildURL({ 'target': 'images', 'resize_completed': 1 });
          }
        }
      );

    var height = 0;
    jQuery('.resize-completed .files.std ul li.file').each(
      function () {
        height += jQuery(this).outerHeight();
      }
    );

    var bracket = jQuery('.resize-completed .files ul li.sum .bracket');
    var diff = bracket.outerHeight() - bracket.innerHeight();

    bracket.height(height - diff);

  }
);
