/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Import / export controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupExportController() {
  jQuery('.export-progress .bar')
    .bind(
      'changePercent',
      function(event, data) {
        if (data && 'undefined' != typeof(data.timeLabel)) {
          jQuery('.export-progress .time').html(data.timeLabel);
        }
      }
    )
    .bind(
      'error',
      function() {
        this.errorState = true;
        core.trigger('export.failed');
      }
    )
    .bind(
      'complete',
      function() {
        if (!this.errorState) {
          core.trigger('export.completed');
        }
      }
    );

}