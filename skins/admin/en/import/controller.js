/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Import / import controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function appendViewAll(element) {
  var buttonText = core.t("Show all warnings/errors");

  element.append('<div class="action-wrapper bottom-fade"><span class="bottom-fade-action view-all">'+buttonText+'</span></div>');
  element.find('.bottom-fade-action').click(function(event) {
    element.animate({
      height: element.data('actual-height')
    }, 200, function(){
      element.removeClass('faded');
      element.find('.action-wrapper').remove();
      appendHideAll(element);
    });
  });
}

function appendHideAll(element) {
  var buttonText = core.t("Hide all warnings/errors");

  element.append('<div class="action-wrapper"><span class="bottom-fade-action hide-all">'+buttonText+'</span></div>');
  element.find('.bottom-fade-action').click(function(event) {
    element.addClass('faded');
    element.animate({
      height: element.data('max-height')
    }, 200, function(){
      element.find('.action-wrapper').remove();
      appendViewAll(element);
    });

  });
}

core.microhandlers.add(
  'Errors fade',
  '.errors-wrapper',
  function () {
    var $this = jQuery(this);
    var maxHeight = intval($this.css('max-height'));
    var actualHeight = $this.find('.errors').height();
    $this.data('max-height', maxHeight);
    $this.data('actual-height', actualHeight);

    if ( actualHeight > maxHeight ) {
      appendViewAll($this);
      $this.removeClass('initial');
      $this.height(maxHeight);
    }
  }
);

jQuery().ready(
  function () {
    var importTarget = core.getCommentedData('.import-page', 'importTarget');
    jQuery('.import-progress .bar')
      .bind(
        'changePercent',
        function (event, data) {
          if (data) {
            if ('undefined' != typeof(data.rowsProcessedLabel)) {
              jQuery('.import-progress .rows-processed').html(data.rowsProcessedLabel);
            }
          }
        }
      )
      .bind(
        'error',
        function () {
          this.errorState = true;
          self.location = URLHandler.buildURL({ 'target': importTarget, 'failed': 1 });
        }
      )
      .bind(
        'complete',
        function () {
          if (!this.errorState) {
            self.location = URLHandler.buildURL({ 'target': importTarget, 'completed': 1 });
          }
        }
      );

    jQuery('#files').live(
      'change',
      function () {
        if (jQuery('#files').val()) {
          jQuery('.import-box .submit').removeClass('disabled');
        } else {
          jQuery('.import-box .submit').addClass('disabled');
        }
      }
    );

    jQuery('.import-box.import-begin form').submit(
      function () {
        if (!jQuery('#files').val()) {
          return false;
        }
      }
    );
  }
);
