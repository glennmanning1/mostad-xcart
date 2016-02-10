{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Errors and warnings list template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="import.failed.content.errors", weight="100")
 * @ListChild (list="import.completed.content.errors", weight="100")
 *}

<h3>{getTitle()}</h3>
<div class="errors-wrapper faded initial">
  <ul FOREACH="getFiles(),file" class="errors">
    <li class="title">
      <i class="icon-file-alt"></i> 
      {file.file}
      <span IF="file.countW" class="count-w">{file.countW}</span>
      <span IF="file.countE" class="count-e">{file.countE}</span>
    </li>
    <li FOREACH="getErrorsGroups(file.file),errorGroup" class="clearfix type-{errorGroup.type}">
      <div class="message">
        <div class="message-text">{getGroupErrorMessage(errorGroup)}</div>
        <hr>
        <div class="rows">{getGroupErrorRows(errorGroup)}</div>
      </div>
      <div class="text">{getErrorText(errorGroup)}</div>
    </li>
  </ul>
</div>
