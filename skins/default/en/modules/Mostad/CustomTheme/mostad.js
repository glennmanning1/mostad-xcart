// perform JavaScript after the document is scriptable.
var oneId;
var twoId;
var threeId;
var $issueSelect;
var $issueSelectOptions;
var $issueBoxes;
var currentlyChecked;
$(function() {
    // setup ul.tabs to work as tabs for each div directly under div.panes

    $("#tabs").tabs({
        beforeLoad: function(event, ui) {
            return false;
        }
    });

    bindDialogs();

    if ($('.planning-letter').length >= 1) {

        setIssueSelect();
        bindChecks();

        $('.add2cart').on('click', function(event) {

            currentlyChecked = $issueBoxes.filter(':checked').length;
            if (
                $issueSelect.val() == oneId && currentlyChecked == 1
                || $issueSelect.val() == twoId && currentlyChecked == 2
                || $issueSelect.val() == threeId && currentlyChecked == 3
            ) {

            } else {
                alert("You must select all of your desired issues.")
                event.preventDefault();
                event.stopPropagation();
            }

        });

    }
});
core.registerTriggersBind(
    'update-product-page',
    function(product) {
        // If we don't have the approrpiate parts, get out
        if ($('.planning-letter').length != 1) {
            return;
        }
        setIssueSelect();
        bindChecks();
        if ($issueSelect.val() == threeId) {
            $issueBoxes.attr('checked', 'checked');
        } else {
            currentlyChecked = $issueBoxes.filter(':checked').length;
            if (
                $issueSelect.val() == oneId && currentlyChecked > 1
                || $issueSelect.val() == twoId && currentlyChecked > 2
            ) {
                $issueBoxes.attr('checked', false);
            }
        }

    });

core.registerTriggersBind(
    'update-product-page',
    function(product) {
        cleanupDialogs();
        bindDialogs();
        setIssueSelect();
        bindChecks();
    });

function cleanupDialogs() {
    $('.dialog-target:not(.ui-dialog-content)').each(function(index, element) {
        var id = $(element).attr('id');
        if (typeof id == 'string') {
            $("[id='" + id + "'].ui-dialog-content").remove();
        }

    });
}


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
function setIssueSelect() {
    $issueSelect = $('select:first');
    $issueSelectOptions = $issueSelect.find('option');

    $.each($issueSelectOptions, function(index, element) {
        var $option = $(element);
        var optionString = $option.html();
        if (typeof optionString === "string" && optionString != "") {
            if (optionString.indexOf("One") >= 0) {
                oneId = $option.attr('value');
            }
            if (optionString.indexOf("Two") >= 0) {
                twoId = $option.attr('value');
            }
            if (optionString.indexOf("Three") >= 0) {
                threeId = $option.attr('value');
            }
        }
    });

    $issueBoxes = $('input:checkbox');
    $.each($issueBoxes, function(index, element) {
        var $checkbox = $(element);
        var $label = $checkbox.parents('label');

        if ($label.length && !$label.html().includes('Issue')) {
            $issueBoxes.splice(index, 1);
        }
    });
}

function bindChecks() {
    $issueBoxes.off('click.mostad');
    $issueBoxes.on('click.mostad', function(event) {
        currentlyChecked = $issueBoxes.filter(':checked').length;
        if ($issueSelect.val() == oneId && currentlyChecked > 1) {
            event.preventDefault();
            event.stopPropagation();
            alert('You can only select one issue!');
        }

        if ($issueSelect.val() == twoId && currentlyChecked > 2) {
            event.preventDefault();
            event.stopPropagation();
            alert('You can only select two issues!');
        }

        if ($issueSelect.val() == threeId) {
            event.preventDefault();
            event.stopPropagation();
        }
    });
}

if (typeof ProductDetailsView !== "undefined") {
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
            // this.base.find('.product-image-gallery li.variant-image').remove();

        }

        if (imageChanged) {
            // Gallery reinitialization
            this.gallery = jQuery('.image .product-image-gallery li', this.base);
            this.hideLightbox();

            this.base.find('.product-image-gallery li:eq(0) a').click();
        }

    };
}

function checkQty(field, rules, i, options) {
    console.log(field, rules, i, options);
    var mod = parseInt(rules[9]);
    var val = parseInt(field.val());
    var diff = val % mod;

    if (diff !== 0) {
        return 'Must be order in multiples of ' + mod;
    }

}