/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Multiselect microcontroller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function initMultiSelect (elem) {
  jQuery(elem).multiSelect({
    selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"Nicaragua\"'>",
    selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"Nicaragua\"'>",
    selectableFooter: "<div class='custom-footer'>Available</div>",
    selectionFooter: "<div class='custom-footer'>Selected</div>",
    afterInit: function(ms){
      var that = this,
          $selectableSearch = that.$selectableUl.prev(),
          $selectionSearch = that.$selectionUl.prev(),
          selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
          selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
      .on('keydown', function(e){
        if (e.which === 40){
          that.$selectableUl.focus();
          return false;
        }
      });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
      .on('keydown', function(e){
        if (e.which == 40){
          that.$selectionUl.focus();
          return false;
        }
      });
    },
    afterSelect: function(){
      this.qs1.cache();
      this.qs2.cache();
    },
    afterDeselect: function(){
      this.qs1.cache();
      this.qs2.cache();
    }
  });
}

CommonElement.prototype.handlers.push(
  {
    pattern: 'input.select-country select.country-multiselect',
    canApply: function () {
      return 0 < this.$element.filter('select.country-multiselect').length;
    },
    handler: function () {
      this.$element.data('jqv', {validateNonVisibleFields: true});
      initMultiSelect(this.$element);
   }
  }
);