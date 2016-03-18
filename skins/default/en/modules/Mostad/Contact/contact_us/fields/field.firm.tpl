{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price value
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="contact-us.send.fields", weight="150")
 *}

<div class="form-item">
  <label for="firm">
    {t(#Your firm name#)}
  </label>
  <widget class="XLite\View\FormField\Input\Text" placeholder="{t(#Firm Name#)}" fieldName="firm" value="" fieldOnly="true" required="false" />
</div>
