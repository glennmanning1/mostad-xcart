/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Product details controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/**
 * Controller
 */
function TopSellersList(base)
{
    TopSellersList.superclass.constructor.apply(this, arguments);

    this.bind('local.loaded', _.bind(this.setHandler, this));
    this.setHandler();
}

extend(TopSellersList, ALoadable);

TopSellersList.autoload = function()
{
    jQuery('div.top-sellers').each(
        function() {
            new TopSellersList(this);
        }
    );
};

TopSellersList.initialRequested = false;

TopSellersList.prototype.shadeWidget = true;

TopSellersList.prototype.widgetTarget = 'main';

TopSellersList.prototype.widgetClass = 'XLite\\View\\Product\\TopSellersBlock';

TopSellersList.prototype.setHandler = function () {
    var self = this;
    jQuery('.period-box .field select', 'div.top-sellers').change(function () {
        var id = jQuery('option:selected', this).val();
        self.load({period: id});
    })
};

core.autoload(TopSellersList);

/*

jQuery().ready(
  function() {

    // Tabs
    jQuery('.top-sellers .period-box .field select', this.base).change(
      function () {

        var id = jQuery('.top-sellers .period-box .field select option:selected').val();

        var box = jQuery(this).parents('.top-sellers');
        box.find('.block-container').hide();
        box.find('#period-' + id).show();

        return true;
      }
    );
  }
);

    */