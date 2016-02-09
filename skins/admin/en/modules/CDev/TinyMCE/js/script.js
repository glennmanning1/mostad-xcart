/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * TinyMCE-based textarea controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var configTinyMCE;

function TinyMCE(base)
{
  this.callSupermethod('constructor', arguments);
  var self = this;
  jQuery('textarea.tinymce').each(function() {
    var id = $(this).attr('id');
    if (id) {
      self.initialization('#' + id);
      this.commonController.bind(
        'local.validate',
        _.bind(self.specialValidate, self, id)
      );
    } else {
      self.initialization('textarea.tinymce');
    }
  });
}

extend(TinyMCE, CommonElement);

TinyMCE.prototype.isRequired = function (field)
{
  var rulesParsing = field.attr('class');
  var getRules = /validate\[(.*)\]/.exec(rulesParsing);

  if (!getRules) {
    return false;
  }

  var str = getRules[1];
  var rules = str.split(/\[|,|\]/);
  console.log(rules.indexOf('required'));
  return -1 !== rules.indexOf('required');
}

TinyMCE.prototype.specialValidate = function(id, event, state)
{
  if (!this.isRequired(jQuery('#' + id))) {
    return;
  };
  var elem = tinymce ? tinymce.get(id) : null;

  if (elem && elem.getContent() === '') {
    var name = '';
    var label = jQuery('label[for=' + id + ']');
    if (label && label.length > 0) {
      name = label.attr('title');
    } else {
      name = id;
    }
    core.trigger(
      'message',
      {
        type: 'error',
        message: core.t('The X field is empty', {name: name})
      }
    );
    state.result = false;
  }
};

TinyMCE.prototype.initialization = function(selector)
{
  // Retrive configuration for the tinyMCE object from the PHP settings
  configTinyMCE = core.getCommentedData(jQuery(selector).eq(0).parent().eq(0));

  tinymce.suffix = '.min';
  tinymce.base = 'skins/admin/en/modules/CDev/TinyMCE/js/tinymce';

  tinymce.init({
    selector: selector,
    content_css: configTinyMCE.contentCSS,
    body_class: configTinyMCE.bodyClass,
    resize: "both",
    relative_urls: false,
    convert_urls: configTinyMCE.convertUrls,
    subfolder: "",
    theme: "modern",
    width: 723,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "template paste textcolor"
    ],
    toolbar1: "insertfile undo redo | styleselect formatselect fontselect fontsizeselect | bold italic",
    toolbar2: "alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image | print preview media",
    image_advtab: true,
    setup: function (ed) {
      ed.on('change', function (e) {
        jQuery(e.target.getElement()).text(e.level.content).trigger('change');
      });
    }
  });
};

core.autoload('TinyMCE');
