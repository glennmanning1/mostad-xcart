/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Remove button controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonForm.elementControllers.push(
  {
    pattern: '.line .actions .switch-wrapper',
    handler: function () {

      jQuery('button.switch', this).click(
        function () {
          jQuery(this).parents('.switch-wrapper').eq(0).find('input[type=checkbox]').click();
        }
      );

      jQuery('input[type=checkbox]', this).eq(0).change(
        function () {
          var inp = jQuery(this);
          var btn = inp.parents('.switch-wrapper').eq(0).find('button.switch');
          var cell = inp.parents('.line').eq(0);

          if (inp.is(':checked')) {
            btn.addClass('mark');
            cell.addClass('switch-mark');
            inp.val(1);

          } else {
            btn.removeClass('mark');
            cell.removeClass('switch-mark');
            inp.val(0);
          }

          cell.parents('form').change();
        }
      );
    }
  }
);
