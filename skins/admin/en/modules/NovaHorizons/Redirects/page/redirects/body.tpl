{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/ License Agreement
 * @link      https://novahorizons.io/
*}
<div>
    <h1 class="title">Redirects</h1>
    <div class="description">
        <p>
            Create your redirects below by pushing the create button, then entering the Target that you would
            like redirected, then the Path you would like the user directed to.  The path should be everything after
            your base url, ex. https://mystore.com/my-target  the /my-target would go in your target field, and /my-redirect-path
            would go in your redirect field.  Redirects can be enabled or disabled with the button in the first column.
        </p>
    </div>
</div>
<widget class="XLite\Module\NovaHorizons\Redirects\View\Form\ItemList\Redirect" name="list" />
    <widget class="XLite\Module\NovaHorizons\Redirects\View\ItemList\Model\Redirect" />
<widget name="list" end />

<hr/>

<h2 class="title">Import From CSV</h2>

<div class="description">
    <p>CSV should contain two columns and no headers. First column should be the Target URL, second column should be
        the Path that the user should be redirected to. Any other columns are ignored.</p>
</div>

<div class="redirects_import">
    <widget class="\XLite\Module\NovaHorizons\Redirects\View\Form\CsvImport" name="csv_import" />
      <input class="input-file" type="file" name="userfile" />

      <ul>
          <li><label><input type="radio" name="import_mode" value="append" checked="checked"/> Add redirects in CSV to existing list</label></li>
          <li><label><input type="radio" name="import_mode" value="replace"/> Replace all existing redirects with those in CSV file</label></li>
      </ul>

      <div class="clear"></div>

      <widget class="\XLite\View\Button\Submit" style="upload-restore" label="Import" />

    <widget name="csv_import" end />
</div>