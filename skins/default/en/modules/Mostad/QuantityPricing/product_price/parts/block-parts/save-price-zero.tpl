{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="60")
 *}
{if:!hasQuantityPricing()}
<td IF="wholesaleClassPrice.getSavePriceValue()=0">
  <span class="save-price-value-null">&nbsp;</span>
</td>
{end:}