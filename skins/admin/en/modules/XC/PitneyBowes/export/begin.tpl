{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Export page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="XLite\Module\XC\PitneyBowes\View\Form\CatalogExtraction" name="extraction_form" />

<div class="svg export-icon">{getSVGImage(#modules/XC/PitneyBowes/export/icon.svg#):h}</div>

<div class="header clearfix">
	<h2>{t(#Manual catalog extraction#)}</h2>
</div>

<p>{t(#You can set up automatic catalog synchronization or start export manually#)}</p>

<widget class="XLite\Module\XC\PitneyBowes\View\FormField\Select\ExtractionType" fieldName="type" fieldOnly="true" value="full" />

<div class="buttons form-buttons">
	<widget class="XLite\Module\XC\PitneyBowes\View\Button\StartExport" />
	{if:isExportLocked()}
		<p class="export-blocked">{t(#Background export is in progress#)}</p>
	{end:}
</div>

<widget name="extraction_form" end />

<h2>{t(#Last exports#)}</h2>
<widget class="XLite\Module\XC\PitneyBowes\View\ItemsList\Model\PBExport" />