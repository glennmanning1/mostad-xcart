{**
 * @ListChild (list="wholesale.price.widgetlist", weight="40")
 *}

<td>
  <span class="price-value">{formatPrice(wholesalePrice.getDisplayPrice(),null,1):h}</span>
    {if:!hasQuantityPricing()}
        <span class="price-label">/ {t(#each#)}</span>
    {end:}
</td>

