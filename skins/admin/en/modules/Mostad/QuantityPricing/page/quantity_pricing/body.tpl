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
    <p>CSV should contain two columns and no headers. First column should be the Target URL, second column should be
        the Path that the user should be redirected to. Any other columns are ignored.</p>
</div>

