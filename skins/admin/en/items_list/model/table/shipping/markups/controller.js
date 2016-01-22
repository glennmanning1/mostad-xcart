/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Shipping markups controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

core.microhandlers.add(
  'ShippingMarkupsAddAction',
  '.shipping-markups .list-footer',
  function () {
    var $this = jQuery(this);
    setTimeout(function () {
      var container = $this.clone(true, true);
      container.find('button').removeAttr('onclick');

      var itemsListController = $this.closest('.items-list').get(0).itemsListController;
      itemsListController.createActionContainer = container;

      itemsListController.removeAddContainer = function () {
        jQuery('.list-footer', this.container).remove();
      };

      itemsListController.updateAddContainer = function () {
        var lastVisibleRowActions = jQuery('tr:visible:last .actions.right .cell', this.container);
        if (!jQuery('.list-footer', lastVisibleRowActions).length) {
          this.createActionContainer.clone(true, true).prependTo(lastVisibleRowActions);
        }
      };

      itemsListController.hideCreateRemoveButton = function () {
        jQuery('.create .actions.right .separator', this.container).css('visibility', 'hidden');
        jQuery('.create .actions.right .remove-wrapper', this.container).css('visibility', 'hidden');
      };

      itemsListController.showCreateRemoveButton = function () {
        jQuery('.create .actions.right .separator', this.container).css('visibility', 'visible');
        jQuery('.create .actions.right .remove-wrapper', this.container).css('visibility', 'visible');
      };

      itemsListController.checkRemoveButton = function () {
        if (jQuery('.create tr:visible', this.container).length === 1
          && jQuery('.lines tr:visible', this.container).length === 0
        ) {
          this.hideCreateRemoveButton();

        } else {
          this.showCreateRemoveButton();
        }
      };

      itemsListController.bind('local.line.new.add', function () {
        this.removeAddContainer();
        this.updateAddContainer();
        this.checkRemoveButton();

        var zoneId = jQuery(this.container).closest('form').find('#shippingzone').val();
        jQuery('.create tr:visible:last', this.container).addClass('zone-' + zoneId);
      });

      itemsListController.bind('local.line.new.remove', function () {
        this.removeAddContainer();
        this.updateAddContainer();
        this.checkRemoveButton();
      });

      jQuery('.add-shipping .page-tabs .tab a').bind('click', function () {
        setTimeout(function () {
          itemsListController.updateAddContainer();
          itemsListController.checkRemoveButton();
        }, 0);
      });

      var dialog = $this.closest('.ui-dialog-content');
      setTimeout(function () {
        dialog.dialog('option', 'position', {my: 'center center', at: 'center center'});
      }, 0);
    }, 0);
  }
);

core.microhandlers.add(
  'TableTypeSelector',
  '#tabletype',
  function () {

    var changeTableType = _.bind(function () {
      var $this = jQuery(this);
      var value = $this.val();
      var wrapper = $this.closest('form');

      var weight = jQuery('.shipping-markups .cell.weightRange', wrapper);
      var subtotal = jQuery('.shipping-markups .cell.subtotalRange', wrapper);
      var items = jQuery('.shipping-markups .cell.itemsRange', wrapper);

      var markupFlat = jQuery('.shipping-markups .cell.markup_flat', wrapper);

      weight.hide();
      subtotal.hide();
      items.hide();

      markupFlat.toggleClass('break', false);

      switch (value) {
        case 'WSI':
          weight.show();
          subtotal.show();
          items.show();

          markupFlat.toggleClass('break', true);
          break;

        case 'W':
          weight.show();
          break;

        case 'S':
          subtotal.show();
          break;

        case 'I':
          items.show();
          break;
      }
    }, this);

    jQuery(this).bind('change', changeTableType);
    changeTableType();
  }
);

core.microhandlers.add(
  'ShippingZoneSelector',
  '#shippingzone',
  function () {
    var changeShippingZone = _.bind(function () {
      var $this = jQuery(this);
      var value = $this.val();
      var wrapper = $this.closest('form');

      setTimeout(function () {
        jQuery('.lines tr', wrapper).hide();
        jQuery('.lines tr.zone-' + value, wrapper).show();

        jQuery('.create tr', wrapper).not('.create-tpl').hide();
        setTimeout(function () {
          jQuery('.create tr', wrapper).not('.create-tpl').not('.zone-' + value).remove();
        }, 0);

        var itemsListController = wrapper.find('.items-list').get(0).itemsListController;

        if (jQuery('.create tr:visible', wrapper).length > 0 || jQuery('.lines tr:visible', wrapper).length > 0) {
          itemsListController.removeAddContainer();
          itemsListController.updateAddContainer();
        } else {
          jQuery('button.create-inline', wrapper).click();
        }

      }, 0);
    }, this);

    var methodId = jQuery(this).closest('form').find('input[name="methodId"]').val();

    if (methodId) {
      jQuery(this).bind('change', changeShippingZone);
      changeShippingZone();
    } else {
      var $this = jQuery(this);
      setTimeout(function () {
        jQuery('button.create-inline', $this.closest('form')).click();
      }, 0);
    }
  }
);

core.microhandlers.add(
  'ShippingMarkupFormula',
  '.shipping-markups .cell.formula',
  function () {

    var setValue = function (element, value) {
      if (isNaN(value) || 0 == value) {
        element.hide();
      } else {
        element.show();
        jQuery('.part-value', element).text(value);
      }
    };

    var getHandler = function (elementClass) {
      return function () {
        var wrapper = jQuery(this).closest('tr.line');
        var element = wrapper.find('.formula .' + elementClass);
        var value = parseFloat(jQuery(this).val());

        jQuery('.formula .plus', wrapper).show();
        setValue(element, value);
        if (jQuery('.formula > span:visible', wrapper).not('.free').length) {
          jQuery('.formula > span.free', wrapper).hide();
        } else {
          jQuery('.formula > span.free', wrapper).show();
        }
        jQuery('.formula > span:visible:last .plus', wrapper).hide();
      }
    };

    var flatInput       = jQuery(this).closest('tr.line').find('.cell.markup_flat input');
    var perItemInput    = jQuery(this).closest('tr.line').find('.cell.markup_per_item input');
    var parcentInput    = jQuery(this).closest('tr.line').find('.cell.markup_percent input');
    var perWeightInput  = jQuery(this).closest('tr.line').find('.cell.markup_per_weight input');

    var itemsList = jQuery('.items-list-table.shipping-markups');

    flatInput.change(getHandler('flat-rate'));
    perItemInput.change(getHandler('items'));
    parcentInput.change(getHandler('subtotal'));
    perWeightInput.change(getHandler('weight'));

    var handler = _.bind(function () {
      _.bind(getHandler('flat-rate'), flatInput.get(0))();
      _.bind(getHandler('items'), perItemInput.get(0))();
      _.bind(getHandler('subtotal'), parcentInput.get(0))();
      _.bind(getHandler('weight'), perWeightInput.get(0))();
      unassignWaitOverlay(itemsList);
    }, this);

    // To force handler works in itemsList creation mode
    handler();
    setTimeout(handler, 0);

    jQuery('#shippingzone').change(function () {
      itemsList.parents('.widget-shipping-editmethod').css('padding-bottom', '30px');
      var waitOverlay = assignWaitOverlay(itemsList);
      waitOverlay.css('z-index', 20000);
      waitOverlay.css('width', itemsList.find('table').css('width'));
      setTimeout(handler, 0);
    });

  }
);

jQuery(function () {
  var infinitySign = jQuery('<div />').html('&#x221E;').text();

  jQuery('.range-wrapper input.with-infinity').live('keyup', function () {
    var value = jQuery(this).val();
    if (value === '999999999.00' || value === '999999999' || value === '') {
      jQuery(this).val(infinitySign);
    } else if (value !== infinitySign && value.search(infinitySign) !== -1) {
      jQuery(this).val(value.replace(infinitySign, ''));
    }
  });
});
