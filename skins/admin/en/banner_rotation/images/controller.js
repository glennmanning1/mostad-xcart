/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(function($) {
    // $('.create-tpl').die();
    core.bind('list.model.table.newLineCreated', function(event, data) {
        var line = $('.create-line').last();

        var uploader = line.find('div.file-uploader');

        var newUploader = uploader.clone();
        uploader.remove();
        line.find('.cell.image .table-value > div').append(newUploader);

        new FileUploader(newUploader);
        line
          .find(':input')
          .each(
            function () {
                var el = $(this).parents('.table-value').children('div');

                if (el.data('name') && data.idx) {
                    var newName = el.data('name').replace(/\[0\]/, '[' + (-1 * data.idx) + ']');
                    el.data('name', newName);
                    var uploader = el.find('.file-uploader');
                    uploader.data('object-id', (-1 * data.idx));
                }
            }
          );
    });
});