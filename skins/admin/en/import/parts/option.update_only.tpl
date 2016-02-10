{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Import begin section : settings : update-mode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="import.begin.options", weight="100")
 *}

<li class="import-mode-option">
  <widget class="\XLite\View\FormField\Select\Regular" fieldName="options[updateOnly]" fieldId="importMode" label="{t(#Import mode#)}" value="{config.Import.updateOnly}" options="{getImportModeOptions()}" />
  <widget IF="getImportModeComment()" class="\XLite\View\Tooltip" text="{getImportModeComment()}" isImageTag=true className="help-icon" placement="bottom"/>
</li>
