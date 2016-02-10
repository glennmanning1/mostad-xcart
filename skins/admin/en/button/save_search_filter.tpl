{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * 'Save search filter' button template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div {printTagAttributes(getAttributes()):h}>
  <div class="button-label">{getButtonLabel()}</div>
  <div class="button-action">
    <input type="text" name="{getFilterFieldName()}" value="{getFilterName()}" placeholder="{getPlaceholder()}" />
    <input IF="getFilterId()" type="hidden" name="{getFilterIdFieldName()}" value="{getFilterId()}" />
    <widget class="\XLite\View\Button\Regular" label="{getActionButtonLabel()}" action="{getDefaultAction()}" />
  </div>
</div>
