{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping estimator : address : zipcode
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="shippingEstimator.address", weight="30")
 *}

<li class="zipcode" IF="hasField(#zipcode#)">
  <widget class="\XLite\View\FormField\Input\Text" fieldName="destination_zipcode" value="{getZipcode()}" label="{t(#Zip code#)}" required="true" />
</li>
