{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Restore snapshot
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.ready_to_install.create_backup.actions", weight="50")
 *}

{if:isCurrentSnapshotAvailable()}
<div class="upgrade-note current-snapshot">
    <span class="current-snapshot-label">{t(#Restores to current state of active addons (use in case of emergency)#):h}:</span>
    <div class="current-snapshot-link-block safe-mode-link">
      <widget class="XLite\View\Button\CopyLink" copy="{getCurrentSnapshotURL()}"  />
      {getCurrentSnapshotURL()}
    </div>
</div>
{end:}
