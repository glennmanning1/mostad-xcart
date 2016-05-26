/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Slidebar
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function slidebar(){
    jQuery(function () {
        jQuery('#slidebar').mmenu({
            extensions: ['pagedim-black']
        }, {
            offCanvas: {
                pageSelector: "#page-wrapper"
            }
        });

        var api = jQuery('#slidebar').data('mmenu');
        core.trigger('mm-menu.created', api);
        api.bind('closed', function () {
            api.closeAllPanels();
        });

        var isIE11 = !!navigator.userAgent.match(/Trident.*rv[ :]*11\./);
        if(isIE11){
            jQuery('html').addClass('ie11');
        }

        jQuery('.dropdown-menu#search_box').parent().on('shown.bs.dropdown', function () {
            jQuery('#header').addClass('hidden');
        });

        jQuery('.dropdown-menu#search_box').parent().on('hidden.bs.dropdown', function () {
            jQuery('#header').removeClass('hidden');
        });
    });
}

core.autoload(slidebar);