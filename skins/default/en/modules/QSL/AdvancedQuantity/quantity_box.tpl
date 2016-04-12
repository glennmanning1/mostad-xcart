{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Main element (input)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.quantity-box", weight="20")
 *}

{if:isSelectBox()}
    <select name="{getBoxName()}" id="{getBoxId()}" class="{getClass()}" >
        {foreach:getQuantitiesAsOptions(),id,option}
            <option value="{id}" selected="{isSelectedQuantity(id)}" data-quantity="{option.quantity}">{option.name}</option>
        {end:}
    </select>
    {if:isDisplayUnitsForSelectBox()}
        <select name="unitid" class="{getQuantityUnitSelectorClass()}">
            {foreach:product.quantityUnits,unit}
                <option value="{unit.id}" data-multiplier="{unit.multiplier}" selected="{isSelectedUnit(unit)}">{unit.name}</option>
            {end:}
        </select>
    {end:}
{else:}
    <widget template="product/quantity_box/parts/quantity_box.tpl" />
    {if:hasUnits()}
        <select name="unitid" class="{getQuantityUnitSelectorClass()}">
            {foreach:product.quantityUnits,unit}
                <option value="{unit.id}" data-multiplier="{unit.multiplier}" selected="{isSelectedUnit(unit)}">{unit.name}</option>
            {end:}
        </select>
    {end:}
{end:}
