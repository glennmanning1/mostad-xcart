{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * module
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<img class="icon" src="{moduleParam.getPublicIconURL()}" alt="{moduleParam.getModuleName()}">
<div class="info">
    <div class="name">{moduleParam.getModuleName()}</div>
    <div class="author">
        <span class="author-label">{t(#Author#)}:</span>
        <span class="author-value"> {moduleParam.getAuthor()}</span>
    </div>
    <widget
        IF="moduleParam.getEnabled()"
        class="XLite\View\Button\Link"
        location="{moduleParam.getSettingsForm()}"
        label="{t(#Settings#)}"
        style="main-button settings-button" />
    <widget
        IF="!moduleParam.getEnabled()"
        class="XLite\View\Button\Link"
        location="{moduleParam.getInstalledURL()}"
        label="{t(#View in list#)}"
        style="main-button settings-button" />
</div>