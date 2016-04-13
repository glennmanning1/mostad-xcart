{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Wholesale prices table
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="wholesale.price", weight="20")
 *}

<div id="wholesale-prices" class="dialog-target">
    <div class="dialog-header"></div>
    <div class="dialog-content">
        <table class="wholesale-prices-product-block">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Savings each</th>
                </tr>
            </thead>
            <tbody>

            <tr class="price-row" FOREACH="getWholesalePrices(),wholesalePrice">

                <list type="nested" name="widgetlist" wholesalePrice="{wholesalePrice}" />

            </tr>
            </tbody>

        </table>
    </div>
</div>
