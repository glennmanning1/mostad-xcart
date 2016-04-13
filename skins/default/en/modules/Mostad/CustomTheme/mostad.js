// perform JavaScript after the document is scriptable.
$(function() {
    // setup ul.tabs to work as tabs for each div directly under div.panes

    $("#tabs").tabs({
        beforeLoad: function(event, ui) {
            return false;
        }
    });

    bindDialogs();
});

function bindDialogs() {
    // Set up our dialogs
    $('.dialog-trigger').on('click', function(event) {
        event.preventDefault();
        var target = $(this).data('target');

        if (target) {
            $('#' + target).dialog('open');
        }
    });

    $('.dialog-target').dialog({
        autoOpen:  false,
        draggable: false,
        width:     500
    });
}

core.registerTriggersBind(
    'update-product-page',
    function(product) {
        bindDialogs();
    });


ProductDetailsView.prototype.processVariantImageAsGallery = function(data) {

    var imageChanged = false;

    var variantImageSelected = this.base.find('.product-image-gallery li.variant-image.selected').length > 0;

    if (data && _.isObject(data)) {

        imageChanged = this.base.find('.product-image-gallery li.variant-image a').attr('href') != data.full[2];

        if (imageChanged) {

            // Remove old variant image
            var li = this.base.find('.product-image-gallery li:eq(0)').clone(true);

            this.base.find('.product-image-gallery li.variant-image').remove();

            // Change images
            var elm = li.find('a img');
            elm.attr('width', data.gallery[0])
                .attr('height', data.gallery[1])
                .attr('src', data.gallery[2])
                .attr('alt', data.gallery[3])
                .css({width: data.gallery[0] + 'px', height: data.gallery[1] + 'px'});

            elm = li.find('img.middle');
            elm.attr('width', data.main[0])
                .attr('height', data.main[1])
                .attr('src', data.main[2])
                .attr('alt', data.main[3])
                .css({width: data.main[0] + 'px', height: data.main[1] + 'px'});

            // Change gallery link
            li.find('a')
                .attr('href', data.full[2])
                .attr('rev', 'width: ' + data.full[0] + ', height: ' + data.full[1]);

            li.addClass('variant-image');

            this.base.find('.product-image-gallery li:eq(-1)').after(li);

            // Gallery icon vertical aligment
            var margin = (li.height() - li.find('a img').height()) / 2;

            li.find('a img').css({
                'margin-top':    Math.ceil(margin) + 'px',
                'margin-bottom': Math.floor(margin) + 'px'
            });
        }

    } else if (this.base.find('.product-image-gallery li.variant-image').length > 0) {

        imageChanged = true;

        // Remove old variant image
        this.base.find('.product-image-gallery li.variant-image').remove();

    }

    if (imageChanged) {
        // Gallery reinitialization
        this.gallery = jQuery('.image .product-image-gallery li', this.base);
        this.hideLightbox();

        this.base.find('.product-image-gallery li:eq(0) a').click();
    }

};