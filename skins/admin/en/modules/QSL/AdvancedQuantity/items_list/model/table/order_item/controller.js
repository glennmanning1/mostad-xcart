/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Items list controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

(function(){

  var oldHandleNewItemCreated = OrderItemsList.prototype.handleNewItemCreated;
  OrderItemsList.prototype.handleNewItemCreated = function(event, data)
  {
    oldHandleNewItemCreated.apply(this, [event,data]);

    if (jQuery(data.line).parents('.order-items').length) {
      jQuery(data.line).find('td.cell.quantity_unit .inline-field :input').change(
        function(event) {
          core.trigger('order.item.changed', { line: data.line });
        }
      );
    }
  };

  var oldProcessLine = OrderItemsList.prototype.processLine;
  OrderItemsList.prototype.processLine = function(idx, line)
  {
    oldProcessLine.apply(this, [idx, line]);

    line = jQuery(line);
    line.find('td.amount input.float').change(_.bind(this.handleAmountChange, this));
    line.find('td.quantity_unit :input').change(_.bind(this.handleQuantityUnitChange, this));
  };

  OrderItemsList.prototype.handleAmountChange = function(event)
  {
    var line = jQuery(event.currentTarget).parents('tr').eq(0);
    if (line.find('td.amount input.float').get(0).commonController.validate(true)) {
      this.updateLinePrice(line);
      core.trigger('order.item.changed', { 'line': line });
    }
  };

  OrderItemsList.prototype.handleQuantityUnitChange = function(event)
  {
    var line = jQuery(event.currentTarget).parents('tr').eq(0);
    if (line.find('td.amount input.float').get(0).commonController.validate(true)) {
      this.updateLinePrice(line);
      core.trigger('order.item.changed', { 'line': line });
    }
  };

  OrderItemsList.prototype.handleItemChanged = function(event, data)
  {
    var line = jQuery(data.line);
    var price = parseFloat(line.find('td.cell.price .inline-field .field input').val());
    var qty = parseFloat(line.find('td.cell.amount .inline-field .field input').val());

    var unit = line.find('td.cell.quantity_unit .inline-field .field :input');
    var multiplier = unit.length > 0
      ? parseFloat(jQuery(unit.get(0).options[unit.get(0).selectedIndex]).data('multiplier'))
      : 1;

    if (isNaN(price)) {
      price = 0;
    }

    if (isNaN(qty)) {
      qty = 0;
    }

    if (isNaN(multiplier)) {
      multiplier = 1;
    }

    var total = core.round(price * qty * multiplier, this.e);
    line.find('td.cell.total .value').data('value', total);
    line.find('td.cell.total .value').html(core.numberToString(total, '.', '', this.e));

    if (total <= 0) {
      line.addClass('zero-total');

    } else {
      line.removeClass('zero-total');
    }

    core.trigger('order.items.changed');
  };

})();