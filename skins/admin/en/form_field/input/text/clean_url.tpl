{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Clean URL
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:hasExtension()}
<div IF="hasExtension()" class="cleanurl-wrapper">
  <div class="input-group">
    <input{getAttributesCode():h}/>
    <span class="input-group-addon" data-extension="{getExtension()}">.{getExtension()}</span>
  </div>
</div>
{else:}
<input{getAttributesCode():h}/>
{end:}
<div IF="isCleanURLDisabled()" class="clean-url-disabled-info">
  <i class="fa fa-exclamation-triangle"></i>
  {t(#Clean URLs are disabled. More info#,_ARRAY_(#more_info_url#^buildURL(#settings#,##,_ARRAY_(#page#^#Environment#)))):h}
</div>
<div IF="getErrorMessage()" class="error inline-error">
  {getErrorMessage():h}
  <widget
          class="XLite\View\ToolTip"
          text="{getResolveHint()}"
          caption="{t(#Resolve the conflict#)}"
          isImageTag=false
          className="help-icon" />
</div>

<div class="clean-url-result" data-saved-value="{getSavedValue()}" data-url-template="{getFakeURL()}">
  <span class="result-label">{t(#Result#)}:</span>
  <span class="saved-url">
    {if:isCleanURLDisabled()}      
      <span IF="getURL()">{getURL()}</span>
    {else:}    
      <a IF="getURL()" href="{getURL()}" target="_blank">{getURL()}</a>
    {end:}
  </span>
  <span class="url"></span>
</div>

<div class="clean-url-result-autogenerated">
 {t(#The clean URL will be generated automatically.#)}
</div>

{if:isHistoryConflict()}
<div class="additional-option">
  <input type="checkbox" name="{getNamePostedData(#forceCleanURL#)}" value="1" id="forceCleanURLFlag" />
  <label for="forceCleanURLFlag" class="note">
    <span class="force mark">{t(#Force Clean URL#)}</span>
  </label>
</div>
{end:}

<div class="additional-option">
  <input type="checkbox" name="{getNamePostedData(#autogenerateCleanURL#)}" value="1" checked="{!getValue()}" id="autogenerateFlag" />
  <label for="autogenerateFlag" class="note">{t(#Autogenerate Clean URL#)}</label>
</div>
