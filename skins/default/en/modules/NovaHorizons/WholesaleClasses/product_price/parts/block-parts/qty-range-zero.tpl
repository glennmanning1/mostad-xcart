{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="20")
 *}
<td IF="wholesaleClassPrice.getQuantityRangeEnd()=0">
  <span class="items-range">{wholesaleClassPrice.getQuantityRangeBegin()}</span>
  <span class="items-label">{t(#or more items#)}</span>
</td>
