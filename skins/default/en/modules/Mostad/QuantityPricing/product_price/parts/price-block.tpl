{**
 * @ListChild (list="wholesale.classes.price", weight="20")
 *}
<div id="wholesale-prices" class="dialog-target">
    <div class="dialog-header"></div>
    <div class="dialog-content">
        <table class="wholesale-prices-product-block">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Price</th>
                    {if:!hasQuantityPricing()}
                    <th>Savings each</th>
                    {end:}
                </tr>
            </thead>
            <tbody>

            <tr class="price-row" FOREACH="getWholesaleClassPrices(),wholesaleClassPrice">

                <list type="nested" name="widgetlist" wholesaleClassPrice="{wholesaleClassPrice}" />
            </tr>
            </tbody>

        </table>
    </div>
</div>
