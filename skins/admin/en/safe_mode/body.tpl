{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Safe mode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div id="safe_mode">
  <div class="safe-mode-description">
    {t(#You need hard and soft reset links in case some 3rd party module crashes your web-store#,_ARRAY_(#article#^getArticleURL())):h}
  </div>
  {if:isCurrentSnapshotAvailable()}
  <div class="current-snapshot">
    <span class="current-snapshot-label">{t(#Restores to current state of active addons (use in case of emergency)#):h}:</span>
    <div class="current-snapshot-link-block safe-mode-link">
      <widget class="XLite\View\Button\CopyLink" copy="{getCurrentSnapshotURL()}"  />
      {getCurrentSnapshotURL()}
    </div>
  </div>
  {end:}
  <div class="soft-reset">
    <span class="soft-reset-label">{t(#Disables all addons except ones that are provided by X-Cart Team & Qualiteam (soft reset)#):h}:</span>
    <div class="soft-reset-link-block safe-mode-link">
      <widget class="XLite\View\Button\CopyLink" copy="{getSoftResetURL()}" />
      {getSoftResetURL()}
    </div>
  </div>
  <div class="hard-reset">
    <span class="hard-reset-label">{t(#Disables all addons except ones that are provided by X-Cart Team (hard reset)#):h}:</span>
    <div class="hard-reset-link-block safe-mode-link">
      <widget class="XLite\View\Button\CopyLink" copy="{getHardResetURL()}" />
      {getHardResetURL()}
    </div>
  </div>
  <widget class="\XLite\View\Button\Regular" style="regular-main-button" label="Re-generate links" jsCode="self.location='{buildURL(#safe_mode#,#safe_mode_key_regen#)}'" />
</div>

<div id="new_access_key">
  {t(#After clicking this button, your hard/soft reset links will be regenerated. You need it in case old links were compromised.#)}<br />
  {t(#Once links are regenerated, they will be sent to store administrator email.#)}
</div>
