{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * @ListChild (list="product.quantity-box", weight="20")
 *}
{if:isSelectBox()}
    <select name="{getBoxName()}" id="{getBoxId()}" class="{getClass()}" data-min="{getMinQuantity()}" data-max="{getMaxQuantity()}">
        {foreach:getQuantitiesAsOptions(),id,option}
            <option value="{id}" selected="{isSelectedQuantity(id)}" data-quantity="{option.quantity}">{option.name}</option>
        {end:}
    </select>
{else:}
        <widget template="product/quantity_box/parts/quantity_box.tpl" />
{end:}