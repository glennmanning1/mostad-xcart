{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="50")
 *}
{if:!hasQuantityPricing()}
<td IF="wholesaleClassPrice.getSavePriceValue()>0">
  <span class="save-price-label">{t(#save#)}</span>
  <span class="save-price-value">{wholesaleClassPrice.getSavePriceValue()}%</span>
</td>
{end:}