{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="10")
 *}
<td IF="wholesaleClassPrice.getQuantityRangeEnd()>0">
  <span IF="!wholesaleClassPrice.getQuantityRangeBegin()=wholesaleClassPrice.getQuantityRangeEnd()" class="items-range">{wholesaleClassPrice.getQuantityRangeBegin()}-{wholesaleClassPrice.getQuantityRangeEnd()}</span>
  <span IF="wholesaleClassPrice.getQuantityRangeBegin()=wholesaleClassPrice.getQuantityRangeEnd()" class="items-range">{wholesaleClassPrice.getQuantityRangeBegin()}</span>
  <span class="items-label">{t(#items#)}</span>
</td>
