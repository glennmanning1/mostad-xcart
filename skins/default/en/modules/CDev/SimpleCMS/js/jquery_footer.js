/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * JQuery footer
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function footer() {
    var fh = $('#footer-area').height();
    if (fh > 150) {
        $('#page').css('padding-bottom', fh);
    }
}
function mobileDropdown() {
    if ($('#top-menu.dropdown-menu').hasClass('scrollable') == true) {
        $('#top-menu.dropdown-menu').removeClass('scrollable').removeAttr('style');
    }
    var h1 = $(window).height();
    var h2 = $('#top-menu.dropdown-menu').height();
    var h3 = $('.mobile_header ul.nav-pills').height();
    if (h1 < h2+h3) {
        $('#top-menu.dropdown-menu').addClass('scrollable').height(h1-h3);
    }
}

$(document).ready(function() {
    mobileDropdown();
    footer();
    $(window).resize(footer);
    $(window).resize(mobileDropdown);
    $(function() {
            $('#top-main-menu a, #top-main-menu .primary-title').on('touchstart', function(e) {
                    if ($(this).hasClass('tap') !== true && $(this).parent().parent().hasClass('tap') !== true) {
                            $('ul.tap, a.tap, .primary-title.tap').removeClass('tap');
                    }
                    if ($(this).next('ul').length !== 0) {
                            $(this).toggleClass('tap');
                            if ($(this).hasClass('tap') == true) {
                                    e.preventDefault();	
                            }
                            $(this).next('ul').toggleClass('tap');
                    }
                    $(document).on('touchstart', function(e) {
                            if($(e.target).closest('.tap').length == 0) {
                                    $('ul.tap, a.tap, .primary-title.tap').removeClass('tap');
                            }
                    });
            });
    });
});
