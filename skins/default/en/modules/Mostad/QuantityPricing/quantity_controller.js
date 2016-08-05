core.registerWidgetsParamsGetter(
    'update-product-page',
    function(product) {
        var $select = jQuery('select.quantity');

        if ($select.length) {

            if ($select.val() > 0) {
                $('button.add2cart').attr('disabled', false);
            }

            return {
                quantity: $select.val()
            }
        }

    });

core.registerWidgetsTriggers(
    'update-product-page',
    function() {
        return 'select.quantity';
    }
);

core.registerTriggersBind(
    'update-product-page',
    function() {
        jQuery('select.quantity').change(
            function() {
                core.trigger('update-product-page', jQuery('form.product-details input[name="product_id"]').val());
            }
        );
    }
);

core.registerShadowWidgets(
    'update-product-page',
    function() {
        return 'select.quantity';
    }
);

core.registerShadowWidgets('update-product-page', function() {
    return '.widget-fingerprint-product-wholesale-prices';
});

$(function() {
    var $select = $('select.quantity');

    if ($select.val() == 0) {
        $('button.add2cart').attr('disabled', 'disabled');
    }
    // console.log('wat');
});