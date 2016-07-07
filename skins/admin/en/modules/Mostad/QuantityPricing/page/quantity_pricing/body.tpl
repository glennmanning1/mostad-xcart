{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
*}
<div>
    <h1 class="title">Quantity Pricing</h1>
    <h3 class="title">Import From CSV</h3>
    <div class="description">
        <p>
            CSV should contain at least two columns, separated by the pipe character "<code>|</code>" and no headers.  First column should be the SKU of the product or variant,
            or the name of the Wholesale Class Pricing Set. The second column should be a string of comma separated
            quantity price sets, where the price is the per piece price of the item.
            <code>25:13.840,50:9.608,75:8.332</code>
            This program will floor the price.
        </p>
    </div>
</div>
<div class="quantity_pricing_import">
    <widget class="\XLite\Module\Mostad\QuantityPricing\View\Form\CsvImport" name="csv_import" />
      <input class="input-file" type="file" name="userfile" />

      <ul>
          <li><label><input type="radio" name="import_mode" value="append" checked="checked"/> Add Pricing to existing pricing</label></li>
          <li><label><input type="radio" name="import_mode" value="replace"/> Replace all existing prices with those in CSV file</label></li>
      </ul>

      <div class="clear"></div>

      <widget class="\XLite\View\Button\Submit" style="upload-restore" label="Import" />

    <widget name="csv_import" end />
</div>

<hr/>

<h3 class="title">Export to CSV</h3>
<div class="description">
    <p>
        Export of all the current quantity pricing for ease of updating.
    </p>
</div>
<div class="quantity_pricing_export">
    <widget class="\XLite\Module\Mostad\QuantityPricing\View\Form\CsvExport" name="csv_export" />

      <widget class="\XLite\View\Button\Submit" style="upload-restore" label="Export" />

    <widget name="csv_export" end />
</div>
