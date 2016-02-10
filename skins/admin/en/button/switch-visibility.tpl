{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Remove button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="switch-wrapper {getStyle()}">
  <button type="button" class="{getStyle()} {if:isEnabled()}mark{end:}" title="{t(getButtonLabel())}" tabindex="-1"><i class="fa fa-power-off"></i></button>
  <input type="hidden" name="{getName()}" value="0" tabindex="-1" />
  <input type="checkbox" name="{getName()}" value="{isEnabled()}" {if:isEnabled()}checked{end:} tabindex="-1" />
</div>
