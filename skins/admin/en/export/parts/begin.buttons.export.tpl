{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Export completed section : button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="export.begin.buttons", weight="100")
 *}

<div class="export-button-container">
	<widget class="XLite\View\Button\StartExport" />
	{if:isExportLocked()}
		<p class="export-blocked">{t(#Background export is in progress#)}</p>
	{end:}
</div>
