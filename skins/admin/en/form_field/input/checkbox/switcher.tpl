{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Switcher checkbox
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="input-field-wrapper {getWrapperClass()}">
{displayCommentedData(getCommentedData())}
<input type="hidden" name="{getName()}" value="" />
<input{getAttributesCode():h} />
<div class="widget" title="{t(getWidgetTitle())}" data-enabled-label="{t(getEnabledLabel())}" data-disabled-label="{t(getDisabledLabel())}">
<i class="fa {getIcon()}"></i>
</div>
</span>
