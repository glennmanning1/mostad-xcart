{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template for Upgrade access level selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget template="form_field/select.tpl" />
<widget class="\XLite\View\Tooltip" text="{t(getHelpMessage())}" isImageTag=true className="help-icon" />
<widget class="\XLite\View\Button\CheckForUpdates"
        label="{t(#Check for updates#)}"
        clear="{false}" />
