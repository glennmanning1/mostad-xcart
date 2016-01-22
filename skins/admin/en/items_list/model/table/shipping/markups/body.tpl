{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Markups list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="list{if:!hasResults()} list-no-items{end:}">

  <div class="lines">
  {foreach:getPageData(),idx,entity}
  <ul {printTagAttributes(getLineAttributes(idx,entity)):h}>
    <li FOREACH="getColumns(),column" class="{getColumnClass(column,entity)}">
      <div class="cell">
        <widget IF="isTemplateColumnVisible(column,entity)" template="{column.template}" idx="{idx}" entity="{entity}" column="{column}" editOnly="{column.editOnly}" viewOnly="{isStatic()}" />
        <widget IF="isClassColumnVisible(column,entity)" class="{column.class}" idx="{idx}" entity="{entity}" column="{column}" itemsList="{getSelf()}" fieldName="{column.code}" fieldParams="{column.params}" editOnly="{column.editOnly}" viewOnly="{isStatic()}" />
        {if:isEditLinkEnabled(column,entity)}
        <div class="entity-edit-link" {getEditLinkAttributes(entity,column)}>
          <a href="{buildEntityURL(entity,column)}" class="regular-button" role="button">{getEditLinkLabel(entity)}</a>
        </div>
        {end:}
        <list type="inherited" name="{getCellListNamePart(#cell#,column)}" column="{column}" entity="{entity}" />
      </div>
    </li>
  </ul>
  <list type="inherited" name="row" idx="{idx}" entity="{entity}" />
  {end:}
  </div>

  <div IF="isBottomInlineCreation()" class="create bottom-create">
  <widget template="items_list/model/table/parts/create_box.tpl" />
  </div>

</div>
