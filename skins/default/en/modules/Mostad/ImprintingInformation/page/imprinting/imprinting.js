$(function() {
    if ($('.status-value input:checked').val() == 'SAME') {
        $('.disable-for-same').attr('disabled', 'disabled');
    }

    $('.status-value input').change(function() {
        var $formEls = $('.disable-for-same');
        if (this.value == 'SAME') {
            $formEls.attr('disabled', 'disabled');
        } else {
            $formEls.removeAttr('disabled');
        }
    });

});