{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Import failed section : errors 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="import.failed.content", weight="100")
 *}

<list name="import.failed.content.errors" />

<div IF="hasErrors()" class="much-errors">{t(#Critical errors have been detected in the files you are trying to import. Please correct the errors and try again.#)}</div>
<div IF="isBroken()" class="much-errors">{t(#Import has been cancelled.#)}</div>
<div IF="hasErrorsOrWarnings()" class="download-errors">
    <a href="{buildURL(#import#,#getErrorsFile#)}">{t(#Download error file#)}</a>
</div>
