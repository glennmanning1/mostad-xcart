(function($){

  $.validationEngineLanguage.allRules.onlySmallLetterNumberUnder = {
    regex: /^[a-z][0-9a-z_]+$/,
    alertText: "* Only small letter, digits and undescore sign are allowed"
  };

  $.validationEngineLanguage.allRules.modifier = {
    regex: /^[\-\+]{1}([0-9]+)([\.,]([0-9]+))?([%]{1})?$/,
    alertText: "* Wrong format"
  };

  $.validationEngineLanguage.allRules.numberWithInfinity = {
    regex: /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+)|∞)?([\.]([0-9]+))?$/,
    alertText: "* Wrong format"
  };

  $.validationEngineLanguage.allRules.integerWithInfinity = {
    regex: /^[\-\+]?(\d+|∞)$/,
    alertText: "* Not a valid integer"
  };

})(jQuery);
