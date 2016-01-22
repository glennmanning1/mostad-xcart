{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Name column
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{if:!isOffline(entity)}
<div IF="entity.getAdminIconURL()}" class="image">
  <img src="{entity.getAdminIconURL()}" alt="{entity.name}" />
</div>
{end:}
<widget IF="{isOffline(entity)}" class="XLite\View\Button\Shipping\EditMethod" method="{entity}" />
<widget IF="{!isOffline(entity)}" template="items_list/model/table/field.tpl" column="{column}" entity="{entity}" />
<widget IF="{isOffline(entity)}" template="items_list/model/table/shipping/carriers/cell.zones.tpl" entity="{entity}" />
