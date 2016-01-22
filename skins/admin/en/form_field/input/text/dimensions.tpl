{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Dimesions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="dimension-field dimension-length">
  <widget
    class="XLite\View\FormField\Input\Text\Float"
    fieldName="{getSubFieldName(#length#)}"
    value="{getLength()}"
    label="{t(#Length#)}" />
</div>

<div class="dimension-field dimension-width">
  <widget
    class="XLite\View\FormField\Input\Text\Float"
    fieldName="{getSubFieldName(#width#)}"
    value="{getWidth()}"
    label="{t(#Width#)}" />
</div>

<div class="dimension-field dimension-height">
  <widget
    class="XLite\View\FormField\Input\Text\Float"
    fieldName="{getSubFieldName(#height#)}"
    value="{getHeight()}"
    label="{t(#Height#)}" />
</div>