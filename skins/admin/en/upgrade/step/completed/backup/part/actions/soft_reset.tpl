{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Soft reset
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="upgrade.step.completed.backup.actions", weight="100")
 * @ListChild (list="upgrade.step.ready_to_install.create_backup.actions", weight="100")
 *}

<div class="upgrade-note soft-reset">
  <span class="soft-reset-label">{t(#Disables all addons except ones that are provided by X-Cart Team & Qualiteam (soft reset)#):h}:</span>
  <div class="soft-reset-link-block safe-mode-link">
	  <widget class="XLite\View\Button\CopyLink" copy="{getSoftResetURL()}"  />
	  {getSoftResetURL()}
  </div>
</div>
