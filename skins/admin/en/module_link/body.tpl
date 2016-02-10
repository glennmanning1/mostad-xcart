{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Module banner template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="module-link {getStyleClass()}">
    <span class="module-button">
        {if:isIconVisible()}
            <img class="module-icon" src="{getModuleIcon()}" alt="{getStringModuleName()}">
        {end:}
        <a href="{getModuleURL()}">{getLabelText()}</a>
    </span>
</div>
