{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="40")
 *}

<td>
  <span class="price-value">{formatPrice(wholesaleClassPrice.getDisplayPrice(),null,1):h}</span>
  <span class="price-label">/ {t(#each#)}</span>
</td>
