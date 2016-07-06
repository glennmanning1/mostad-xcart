{**
 * @ListChild (list="wholesale.classes.price.widgetlist", weight="40")
 *}

<td>
  <span class="price-value">{formatPrice(wholesaleClassPrice.getDisplayPrice(),null,1):h}</span>
    blerb
    {if:!hasQuantityPricing()}
        <span class="price-label">/ {t(#each#)}</span>
    {e}
</td>

