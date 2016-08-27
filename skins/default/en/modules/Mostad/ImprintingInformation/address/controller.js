core.bind(
  'model-selector.address.selected',
  function(event, data) {
    var $wrapper = jQuery(data.element).closest('.model-selector');

    jQuery('.model-not-defined', $wrapper).addClass('hidden');
    jQuery('.model-is-defined', $wrapper).html(data.data.selected_value).removeClass('hidden');

    jQuery(data.element).val(htmlspecialchars_decode(data.data.selected_value));
  }
);

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return this.$element.is('.model-input-selector');
    },
    handler: function() {
      jQuery('.model-selector.data-type-address .model-not-defined').removeClass('hidden');
    }
  }
);

core.bind(
  'model-selector.address.not-selected',
  function(event, data) {
    var $wrapper = jQuery(data.element).closest('.model-selector');

    jQuery('.model-is-defined', $wrapper).html('').addClass('hidden');
    jQuery('.model-not-defined', $wrapper).removeClass('hidden');
  }
);


