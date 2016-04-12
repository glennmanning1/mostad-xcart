/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Quantity controller for order item
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

// Quanitty minumum
CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return 0 < this.$element.filter('input.quantity').length
        && 0 < this.$element.nextAll('select.quantity-unit').length
        && this.$element.attr('class').search(/min\[([0-9\.]+)\]/) !== -1;
    },
    handler: function () {
      var baseMin = parseFloat(this.$element.attr('class').match(/min\[([0-9\.]+)\]/)[1]);
      var unit = this.$element.nextAll('select.quantity-unit');
      var match = this.$element.attr('class').match(/fraction-length-([0-9]+)/);
      var fractionLength = match ? parseInt(match[1]) : 0;

      unit.change(
        _.bind(
          function(event) {
            var option = jQuery(event.target.options[event.target.selectedIndex]);
            var multiplier = parseFloat(option.data('multiplier'));
            var min = Math.floor(baseMin / multiplier * Math.pow(10, fractionLength)) / Math.pow(10, fractionLength);

            this.$element.attr(
              'class',
              this.$element.attr('class').replace(/min\[([0-9\.]+)\]/, 'min[' + min + ']')
            );

            return this.$element.val() >= min;
          },
          this
        )
      );
      unit.change();
    }
  }
);

// Quantity maximum
CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return 0 < this.$element.filter('input.quantity').length
        && 0 < this.$element.nextAll('select.quantity-unit').length
        && this.$element.attr('class').search(/max\[([0-9\.]+)\]/) !== -1;
    },
    handler: function () {
      var base = parseFloat(this.$element.attr('class').match(/max\[([0-9\.]+)\]/)[1]);
      var unit = this.$element.nextAll('select.quantity-unit');
      var match = this.$element.attr('class').match(/fraction-length-([0-9]+)/);
      var fractionLength = match ? parseInt(match[1]) : 0;

      unit.change(
        _.bind(
          function(event) {
            var option = jQuery(event.target.options[event.target.selectedIndex]);
            var multiplier = parseFloat(option.data('multiplier'));
            var max = Math.floor(base / multiplier * Math.pow(10, fractionLength)) / Math.pow(10, fractionLength);

            this.$element.attr(
              'class',
              this.$element.attr('class').replace(/max\[([0-9\.]+)\]/, 'max[' + max + ']')
            );

            return this.$element.val() <= max;
          },
          this
        )
      );
      unit.change();
    }
  }
);

