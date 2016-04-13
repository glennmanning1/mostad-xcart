// perform JavaScript after the document is scriptable.
$(function() {
    // setup ul.tabs to work as tabs for each div directly under div.panes
    console.log('firing');

    $("#tabs").tabs({
        beforeLoad: function(event, ui) {
            return false;
        }
    });


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
});

